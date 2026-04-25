<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Category;
use Illuminate\Http\Request;

class AttractionController extends Controller
{
    // Home page - show all attractions with search/filter
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

    // Show single attraction detail
    public function show($id)
    {
        $attraction = Attraction::with('category')->findOrFail($id);
        return view('attractions.show', compact('attraction'));
    }

    // Map view
   public function map()
{
    $attractions = Attraction::with('category')->where('distance', '<=', 25)->get();
    $categories  = Category::all();

    $attractionsJson = $attractions->map(fn($a) => [
        'id'       => $a->attraction_id,
        'name'     => $a->name,
        'category' => $a->category->category_name ?? '',
        'distance' => $a->distance,
        'location' => $a->location,
        'lat'      => $a->latitude,
        'lng'      => $a->longitude,
        'url'      => route('attractions.show', $a->attraction_id),
    ]);

    return view('attractions.map', compact('attractions', 'categories', 'attractionsJson'));
}
}

