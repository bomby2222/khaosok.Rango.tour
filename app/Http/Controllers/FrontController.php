<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Destination;
use App\Models\Resort;
use App\Models\Tour;
use App\Models\Taxi;
use App\Models\RouteMap;
use App\Models\Setting;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', true)->get();
        
        // 1. ดึงแพ/รีสอร์ทสำหรับโซน Welcome to Khao Sok
        $resorts = Resort::where('status', true)->orderBy('sort_order', 'asc')->get();

        // 2. ดึงสถานที่ท่องเที่ยวสำหรับโซน Best Tours / Destinations
        $destinations = Destination::where('status', true)->orderBy('sort_order', 'asc')->take(6)->get();
        
        // 3. ดึงแพ็กเกจทัวร์แนะนำ
        $featuredTours = Tour::where('status', true)->where('is_featured', true)->take(3)->get();
        if ($featuredTours->isEmpty()) {
            $featuredTours = Tour::where('status', true)->latest()->take(3)->get();
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('front.home', compact('banners', 'resorts', 'destinations', 'featuredTours', 'settings'));
    }

    public function about()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('front.about', compact('settings'));
    }

    // 🗺️ หน้าแผนที่เส้นทางนำเที่ยวแบบลากเส้นพิกัด (Interactive Route Map)
    public function routeMap()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        // ดึงข้อมูลแผนที่และจุด Waypoint ที่สร้างจากหลังบ้าน
        $routeMaps = RouteMap::where('status', true)->orderBy('sort_order', 'asc')->get();
        
        $viewName = view()->exists('front.route-map') ? 'front.route-map' : 'front.route_map';
        return view($viewName, compact('settings', 'routeMaps'));
    }

    // 🚕 หน้าบริการแท็กซี่และรถรับส่งส่วนตัว
    public function taxiTransfers(Request $request)
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        
        // รับค่าโซนเป้าหมาย (เพื่อให้หน้าบ้านรู้ว่าควรเปิดแท็บไหนค้างไว้)
        $selectedZone = $request->query('zone', 'phuket');

        // สำคัญ: ต้องดึงเที่ยวรถ "ทั้งหมด" ที่เปิดใช้งาน เพื่อให้หน้าเว็บนำไปแยกใส่ 4 โซนได้ครบถ้วน
        $taxis = Taxi::where('status', true)->orderBy('sort_order', 'asc')->get();

        return view('front.taxis', compact('taxis', 'selectedZone', 'settings'));
    }

    public function destinations()
    {
        $destinations = Destination::where('status', true)->orderBy('sort_order', 'asc')->paginate(9);
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('front.destinations', compact('destinations', 'settings'));
    }

    public function tours()
    {
        $tours = Tour::where('status', true)->latest()->paginate(9);
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('front.tours', compact('tours', 'settings'));
    }

    public function show($slug)
    {
        $tour = Tour::with('schedules')->where('slug', $slug)->firstOrFail();
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('front.tour_detail', compact('tour', 'settings'));
    }

    public function contact()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('front.contact', compact('settings'));
    }
}