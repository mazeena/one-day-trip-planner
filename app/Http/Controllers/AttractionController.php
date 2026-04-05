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

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sort by distance
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
    public function map(Request $request)
    {
        $attractions = Attraction::with('category')->where('distance', '<=', 25)->get();
        $categories = Category::all();
        return view('attractions.map', compact('attractions', 'categories'));
    }
}
