<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attraction;
use App\Models\TripItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('trip.plan');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('trip.plan');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // Plan my trip page
    public function planTrip()
    {
        $attractions = Attraction::with('category')
                        ->where('distance', '<=', 25)
                        ->orderBy('distance')
                        ->get();

        $myTrips = TripItinerary::with('attractions.category')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('trip.plan', compact('attractions', 'myTrips'));
    }

    // Save a trip
    public function saveTrip(Request $request)
    {
        $request->validate([
            'trip_name'      => 'required|string|max:255',
            'trip_date'      => 'nullable|date',
            'attraction_ids' => 'required|array|min:1',
        ]);

        $trip = TripItinerary::create([
            'user_id'   => Auth::id(),
            'trip_name' => $request->trip_name,
            'trip_date' => $request->trip_date,
        ]);

        foreach ($request->attraction_ids as $order => $attractionId) {
            $trip->attractions()->attach($attractionId, ['order' => $order]);
        }

        return redirect()->route('trip.plan')->with('success', 'Trip saved successfully!');
    }

    // Delete a trip
    public function deleteTrip($id)
    {
        $trip = TripItinerary::where('user_id', Auth::id())->findOrFail($id);
        $trip->delete();
        return redirect()->route('trip.plan')->with('success', 'Trip deleted successfully.');
    }
}