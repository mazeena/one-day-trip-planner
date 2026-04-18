<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Store a new review (admin only)
    public function store(Request $request)
    {
        $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'required|string|max:1000',
        ]);

        Review::create($request->only('reviewer_name', 'rating', 'comment'));

        return redirect()->route('home')->with('success', 'Review added successfully!');
    }

    // Update an existing review (admin only)
    public function update(Request $request, $id)
    {
        $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($id);
        $review->update($request->only('reviewer_name', 'rating', 'comment'));

        return redirect()->route('home')->with('success', 'Review updated successfully!');
    }

    // Delete a review (admin only)
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return redirect()->route('home')->with('success', 'Review deleted successfully!');
    }
}
