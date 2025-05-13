<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user','product')->paginate(20);
        return view('pages.reviews.index', compact('reviews'));
    }
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success','Review deleted.');
    }
}
