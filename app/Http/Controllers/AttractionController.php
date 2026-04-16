<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Category;
use Illuminate\Http\Request;

class AttractionController extends Controller
{
    public function welcome()
    {
        return view('home');
    }

    public function index(Request $request)
    {
        $query = Attraction::with('category')->where('distance', '<=', 25);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $sortOrder = $request->get('sort', 'asc');
        $query->orderBy('distance', $sortOrder);

        $attractions = $query->get();
        $categories = Category::all();

        return view('attractions.index', compact('attractions', 'categories'));
    }

    public function show($id)
    {
        $attraction = Attraction::with('category')->findOrFail($id);
        return view('attractions.show', compact('attraction'));
    }

    public function map(Request $request)
    {
        $attractions = Attraction::with('category')->where('distance', '<=', 25)->get();
        $categories = Category::all();
        return view('attractions.map', compact('attractions', 'categories'));
    }
}
