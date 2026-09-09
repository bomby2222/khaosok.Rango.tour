<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourImage;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::latest()->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'location' => 'required|string',
            'meeting_point' => 'nullable|string',
            'description' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'terms' => 'nullable|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data['slug'] = Str::slug($request->title) . '-' . rand(1000, 9999);
        $data['cover_image'] = $request->file('cover_image')->store('tours', 'public');
        $data['is_featured'] = $request->has('is_featured');
        $data['status'] = $request->has('status');

        $tour = Tour::create($data);

        // บันทึกรูปแกลเลอรีเพิ่มเติม (ถ้ามี)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('tours/gallery', 'public');
                TourImage::create([
                    'tour_id' => $tour->id,
                    'image' => $path,
                ]);
            }
        }

        // เพิ่มรอบวันเดินทางเริ่มต้นเข้าปฏิทิน
        if ($request->filled('schedule_dates')) {
            foreach ($request->schedule_dates as $index => $date) {
                if (!empty($date)) {
                    $seats = $request->schedule_seats[$index] ?? 20;
                    TourSchedule::create([
                        'tour_id' => $tour->id,
                        'travel_date' => $date,
                        'available_seats' => $seats,
                        'is_available' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.tours.index')->with('success', 'บันทึกข้อมูลทัวร์สำเร็จ');
    }

    public function edit(Tour $tour)
    {
        $tour->load(['images', 'schedules']);
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'location' => 'required|string',
            'meeting_point' => 'nullable|string',
            'description' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'terms' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // อัปเดตรูปหน้าปกใหม่
        if ($request->hasFile('cover_image')) {
            if ($tour->cover_image && Storage::disk('public')->exists($tour->cover_image)) {
                Storage::disk('public')->delete($tour->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('tours', 'public');
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['status'] = $request->has('status');

        $tour->update($data);

        // 🗑️ ลบรูปภาพแกลเลอรีที่ถูกเลือกให้ลบ
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = TourImage::where('tour_id', $tour->id)->find($imgId);
                if ($img) {
                    if (Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }
                    $img->delete();
                }
            }
        }

        // 📸 อัปโหลดภาพแกลเลอรีใหม่เพิ่มเติม
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('tours/gallery', 'public');
                TourImage::create([
                    'tour_id' => $tour->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('admin.tours.index')->with('success', 'อัปเดตข้อมูลทัวร์สำเร็จ');
    }

    public function destroy(Tour $tour)
    {
        // 1. ลบไฟล์รูปหน้าปก
        if ($tour->cover_image && Storage::disk('public')->exists($tour->cover_image)) {
            Storage::disk('public')->delete($tour->cover_image);
        }

        // 2. ลบรูปภาพแกลเลอรี
        if ($tour->relationLoaded('images') || method_exists($tour, 'images')) {
            $images = $tour->images;
            if (!empty($images)) {
                foreach ($images as $img) {
                    if (!empty($img->image) && Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }
                }
            }
        }

        // 3. ลบตารางความสัมพันธ์รอบปฏิทิน
        if (method_exists($tour, 'schedules')) {
            $tour->schedules()->delete();
        }

        // 4. ลบข้อมูลทัวร์
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'ลบแพ็กเกจทัวร์สำเร็จ');
    }
}