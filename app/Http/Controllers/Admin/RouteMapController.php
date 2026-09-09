<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteMap;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteMapController extends Controller
{
    public function index()
    {
        $routeMaps = RouteMap::with('tour')->orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.route_maps.index', compact('routeMaps'));
    }

    public function create()
    {
        $tours = Tour::where('status', true)->get();
        return view('admin.route_maps.create', compact('tours'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'tour_id' => 'nullable|exists:tours,id',
            'description' => 'nullable|string',
            'route_color' => 'required|string|max:20',
            'center_lat' => 'required|numeric',
            'center_lng' => 'required|numeric',
            'zoom_level' => 'required|integer|min:3|max:18',
            'waypoints' => 'nullable|array',
            'waypoints.*.name' => 'required|string|max:255',
            'waypoints.*.lat' => 'required|numeric',
            'waypoints.*.lng' => 'required|numeric',
            'waypoints.*.type' => 'required|string',
            'waypoints.*.description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $data['slug'] = Str::slug($request->title) . '-' . rand(100, 999);
        $data['status'] = $request->has('status');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['waypoints'] = array_values($request->waypoints ?? []);

        RouteMap::create($data);

        return redirect()->route('admin.route-maps.index')->with('success', 'บันทึกเส้นทางแผนที่สำเร็จ');
    }

    public function edit(RouteMap $routeMap)
    {
        $tours = Tour::where('status', true)->get();
        return view('admin.route_maps.edit', compact('routeMap', 'tours'));
    }

    public function update(Request $request, RouteMap $routeMap)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'tour_id' => 'nullable|exists:tours,id',
            'description' => 'nullable|string',
            'route_color' => 'required|string|max:20',
            'center_lat' => 'required|numeric',
            'center_lng' => 'required|numeric',
            'zoom_level' => 'required|integer|min:3|max:18',
            'waypoints' => 'nullable|array',
            'waypoints.*.name' => 'required|string|max:255',
            'waypoints.*.lat' => 'required|numeric',
            'waypoints.*.lng' => 'required|numeric',
            'waypoints.*.type' => 'required|string',
            'waypoints.*.description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $data['status'] = $request->has('status');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['waypoints'] = array_values($request->waypoints ?? []);

        $routeMap->update($data);

        return redirect()->route('admin.route-maps.index')->with('success', 'อัปเดตเส้นทางแผนที่สำเร็จ');
    }

    public function destroy(RouteMap $routeMap)
    {
        $routeMap->delete();
        return redirect()->route('admin.route-maps.index')->with('success', 'ลบแผนที่เส้นทางสำเร็จ');
    }
}   