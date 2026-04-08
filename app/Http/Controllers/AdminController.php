<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Attraction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Show login form
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid username or password.'])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // Dashboard
    public function dashboard()
    {
        $totalAttractions = Attraction::count();
        $totalCategories = Category::count();
        $recentAttractions = Attraction::with('category')->latest()->take(5)->get();
        return view('admin.dashboard', compact('totalAttractions', 'totalCategories', 'recentAttractions'));
    }

    // List all attractions
    public function attractionIndex()
    {
        $attractions = Attraction::with('category')->orderBy('name')->get();
        return view('admin.attractions.index', compact('attractions'));
    }

    // Show create form
    public function attractionCreate()
    {
        $categories = Category::all();
        return view('admin.attractions.create', compact('categories'));
    }

    // Store new attraction
    public function attractionStore(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'description' => 'required|string',
            'distance'    => 'required|numeric|min:0|max:25',
            'location'    => 'required|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/attractions'), $imageName);
            $validated['image'] = $imageName;
        }

        Attraction::create($validated);
        return redirect()->route('admin.attractions.index')->with('success', 'Attraction added successfully!');
    }

    // Show edit form
    public function attractionEdit($id)
    {
        $attraction = Attraction::findOrFail($id);
        $categories = Category::all();
        return view('admin.attractions.edit', compact('attraction', 'categories'));
    }

    // Update attraction
    public function attractionUpdate(Request $request, $id)
    {
        $attraction = Attraction::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'description' => 'required|string',
            'distance'    => 'required|numeric|min:0|max:25',
            'location'    => 'required|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($attraction->image && file_exists(public_path('images/attractions/' . $attraction->image))) {
                unlink(public_path('images/attractions/' . $attraction->image));
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/attractions'), $imageName);
            $validated['image'] = $imageName;
        } else {
            // No new image uploaded — keep the existing one
            unset($validated['image']);
        }

        $attraction->update($validated);
        return redirect()->route('admin.attractions.index')->with('success', 'Attraction updated successfully!');
    }

    // Delete attraction
    public function attractionDestroy($id)
    {
        $attraction = Attraction::findOrFail($id);

        if ($attraction->image && file_exists(public_path('images/attractions/' . $attraction->image))) {
            unlink(public_path('images/attractions/' . $attraction->image));
        }

        $attraction->delete();
        return redirect()->route('admin.attractions.index')->with('success', 'Attraction deleted successfully!');
    }
}