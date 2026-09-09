<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResortController extends Controller
{
    public function index()
    {
        $resorts = Resort::orderBy('sort_order', 'asc')->get();
        return view('admin.resorts.index', compact('resorts'));
    }

    public function create()
    {
        return view('admin.resorts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'gallery' => 'nullable|array|max:10',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        // บันทึกภาพปกหลัก
        $data['image'] = $request->file('image')->store('resorts', 'public');

        // บันทึกภาพ Gallery หลายรูป (สูงสุด 10 รูป)
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if (count($galleryPaths) < 10) {
                    $galleryPaths[] = $file->store('resorts/gallery', 'public');
                }
            }
        }
        $data['gallery'] = $galleryPaths;

        $data['status'] = $request->has('status') ? true : false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Resort::create($data);

        return redirect()->route('admin.resorts.index')->with('success', 'Lake resort created successfully.');
    }

    public function edit(Resort $resort)
    {
        return view('admin.resorts.edit', compact('resort'));
    }

    public function update(Request $request, Resort $resort)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'gallery' => 'nullable|array|max:10',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            'delete_gallery' => 'nullable|array',
            'sort_order' => 'nullable|integer',
        ]);

        // อัปเดตรูปปกหลัก
        if ($request->hasFile('image')) {
            if ($resort->image && Storage::disk('public')->exists($resort->image)) {
                Storage::disk('public')->delete($resort->image);
            }
            $data['image'] = $request->file('image')->store('resorts', 'public');
        }

        // จัดการรูปภาพ Gallery
        $currentGallery = is_array($resort->gallery) ? $resort->gallery : [];

        // ลบรูปที่ผู้ใช้ติ๊กเลือกจะลบ
        if ($request->filled('delete_gallery')) {
            foreach ($request->delete_gallery as $delImg) {
                if (Storage::disk('public')->exists($delImg)) {
                    Storage::disk('public')->delete($delImg);
                }
                $currentGallery = array_values(array_filter($currentGallery, fn($img) => $img !== $delImg));
            }
        }

        // เพิ่มรูป Gallery ใหม่
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if (count($currentGallery) < 10) {
                    $currentGallery[] = $file->store('resorts/gallery', 'public');
                }
            }
        }
        $data['gallery'] = $currentGallery;

        $data['status'] = $request->has('status') ? true : false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $resort->update($data);

        return redirect()->route('admin.resorts.index')->with('success', 'Lake resort updated successfully.');
    }

    public function destroy(Resort $resort)
    {
        if ($resort->image && Storage::disk('public')->exists($resort->image)) {
            Storage::disk('public')->delete($resort->image);
        }

        if (is_array($resort->gallery)) {
            foreach ($resort->gallery as $galImg) {
                if (Storage::disk('public')->exists($galImg)) {
                    Storage::disk('public')->delete($galImg);
                }
            }
        }

        $resort->delete();

        return redirect()->route('admin.resorts.index')->with('success', 'Lake resort deleted.');
    }
}