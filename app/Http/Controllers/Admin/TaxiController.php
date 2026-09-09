<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Taxi;
use Illuminate\Http\Request;

class TaxiController extends Controller
{
    public function index()
    {
        $taxis = Taxi::orderBy('zone')->orderBy('sort_order', 'asc')->get();
        return view('admin.taxis.index', compact('taxis'));
    }

    public function create()
    {
        return view('admin.taxis.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'zone' => 'required|in:phuket,khaosok,phangnga,krabi',
            'route_name' => 'nullable|string|max:255',
            'from_location' => 'nullable|string|max:255',
            'to_location' => 'nullable|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_per_person' => 'nullable|numeric|min:0', // 👈 เพิ่มรับค่าราคารายคน
            'duration' => 'nullable|string|max:255',
            'pickup_times' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        // กำหนด route_name อัตโนมัติ ป้องกันค่าว่าง
        if (!empty($request->route_name)) {
            $data['route_name'] = $request->route_name;
        } elseif (!empty($request->from_location) && !empty($request->to_location)) {
            $data['route_name'] = $request->from_location . ' ➔ ' . $request->to_location;
        } else {
            $data['route_name'] = $request->from_location ?? $request->to_location ?? 'เส้นทางรับส่งทั่วไป';
        }

        $data['pickup_times'] = $request->pickup_times ?? 'นัดหมายเวลาได้';
        $data['status'] = $request->has('status');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Taxi::create($data);

        return redirect()->route('admin.taxis.index')->with('success', 'เพิ่มเที่ยวรถรับส่งเรียบร้อยแล้ว');
    }

    public function edit(Taxi $taxi)
    {
        return view('admin.taxis.edit', compact('taxi'));
    }

    public function update(Request $request, Taxi $taxi)
    {
        $data = $request->validate([
            'zone' => 'required|in:phuket,khaosok,phangnga,krabi',
            'route_name' => 'nullable|string|max:255',
            'from_location' => 'nullable|string|max:255',
            'to_location' => 'nullable|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_per_person' => 'nullable|numeric|min:0', // 👈 เพิ่มรับค่าราคารายคนตอนอัปเดต
            'duration' => 'nullable|string|max:255',
            'pickup_times' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if (!empty($request->route_name)) {
            $data['route_name'] = $request->route_name;
        } elseif (!empty($request->from_location) && !empty($request->to_location)) {
            $data['route_name'] = $request->from_location . ' ➔ ' . $request->to_location;
        }

        $data['pickup_times'] = $request->pickup_times ?? $taxi->pickup_times;
        $data['status'] = $request->has('status');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $taxi->update($data);

        return redirect()->route('admin.taxis.index')->with('success', 'อัปเดตเที่ยวรถเรียบร้อยแล้ว');
    }

    public function destroy(Taxi $taxi)
    {
        $taxi->delete();
        return redirect()->route('admin.taxis.index')->with('success', 'ลบเที่ยวรถเรียบร้อยแล้ว');
    }
}