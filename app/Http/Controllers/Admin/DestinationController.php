<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::orderBy('sort_order', 'asc')->get();
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        $data['image'] = $request->file('image')->store('destinations', 'public');
        $data['status'] = $request->has('status');

        Destination::create($data);

        return redirect()->route('admin.destinations.index')->with('success', 'Destination created.');
    }

    // ✏️ ฟังก์ชันเปิดหน้าฟอร์มแก้ไขข้อมูล
    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    // 💾 ฟังก์ชันบันทึกการแก้ไขข้อมูลและรูปภาพ
    public function update(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        // หากมีการอัปโหลดรูปภาพใหม่ ให้ลบรูปเดิมออกจาก storage แล้วบันทึกรูปใหม่
        if ($request->hasFile('image')) {
            if ($destination->image && Storage::disk('public')->exists($destination->image)) {
                Storage::disk('public')->delete($destination->image);
            }
            $data['image'] = $request->file('image')->store('destinations', 'public');
        }

        $data['status'] = $request->has('status');

        $destination->update($data);

        return redirect()->route('admin.destinations.index')->with('success', 'Destination updated successfully.');
    }

    public function destroy(Destination $destination)
    {
        if ($destination->image && Storage::disk('public')->exists($destination->image)) {
            Storage::disk('public')->delete($destination->image);
        }
        
        $destination->delete();
        return redirect()->route('admin.destinations.index')->with('success', 'Destination deleted.');
    }
}