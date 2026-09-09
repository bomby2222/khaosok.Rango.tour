<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    // แสดงรายการรีวิวทั้งหมด + คำนวณคะแนนเฉลี่ย
    public function index()
    {
        $reviews = Review::with('images')->latest()->paginate(10);
        $totalReviews = Review::count();
        $avgRating = $totalReviews > 0 ? round(Review::avg('rating'), 1) : 5.0;

        return view('admin.reviews.index', compact('reviews', 'totalReviews', 'avgRating'));
    }

    // ลบรีวิวและลบไฟล์ภาพที่แนบมาออกจาก Storage
    public function destroy(Review $review)
    {
        if ($review->images && $review->images->count() > 0) {
            foreach ($review->images as $img) {
                Storage::disk('public')->delete($img->image);
            }
        }

        if ($review->image) {
            Storage::disk('public')->delete($review->image);
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
}