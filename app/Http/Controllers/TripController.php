<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attraction;
use App\Models\Category;
use App\Models\Trip;

class TripController extends Controller
{
    public function index()
    {
        $attractions = Attraction::with('category')->orderBy('distance')->get();
        $categories  = Category::all();
        $myTrips     = Auth::check()
                        ? Trip::with('attractions')->where('user_id', Auth::id())->latest()->get()
                        : collect();

        return view('trip.plan', compact('attractions', 'categories', 'myTrips'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'trip_name'        => 'required|string|max:255',
            'trip_date'        => 'nullable|date',
            'attraction_ids'   => 'required|array|min:1',
            'attraction_ids.*' => 'exists:attractions,attraction_id',
        ]);

        $trip = Trip::create([
            'user_id'   => Auth::id(),
            'trip_name' => $request->trip_name,
            'trip_date' => $request->trip_date,
        ]);

        $trip->attractions()->sync($request->attraction_ids);

        return redirect()->route('trip.plan')->with('success', 'Trip saved successfully!');
    }

    public function destroy($id)
    {
        $trip = Trip::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $trip->attractions()->detach();
        $trip->delete();

        return redirect()->route('trip.plan')->with('success', 'Trip deleted.');
    }
}
