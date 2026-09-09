<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // ดึงรีวิวพร้อมรูปภาพทั้งหมด (Eager loading)
        $reviews = Review::with('images')->where('status', true)->latest()->paginate(8);

        $totalReviews = Review::where('status', true)->count();
        $avgRating = $totalReviews > 0 ? round(Review::where('status', true)->avg('rating'), 1) : 0;

        $starCounts = [];
        $starPercentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = Review::where('status', true)->where('rating', $i)->count();
            $starCounts[$i] = $count;
            $starPercentages[$i] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
        }

        return view('front.reviews', compact('reviews', 'totalReviews', 'avgRating', 'starCounts', 'starPercentages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1500',
            'name' => 'nullable|string|max:100',
            'images' => 'nullable|array|max:8', // อัปโหลดได้สูงสุด 8 รูปต่อคอมเมนต์
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $isAnonymous = $request->has('is_anonymous') || empty(trim($request->name ?? ''));
        $name = $isAnonymous ? 'Anonymous Traveler' : trim($request->name);

        $review = Review::create([
            'name' => $name,
            'is_anonymous' => $isAnonymous,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => true,
        ]);

        // บันทึกรูปภาพหลายรูปลงในตาราง review_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('reviews', 'public');
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('reviews.index')->with('success', 'Your review and photos have been posted successfully!');
    }
}