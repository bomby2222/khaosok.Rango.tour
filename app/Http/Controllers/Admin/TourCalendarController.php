<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Http\Request;

class TourCalendarController extends Controller
{
    // แสดงหน้าจอจัดการปฏิทินของทัวร์
    public function index(Tour $tour)
    {
        $schedules = $tour->schedules()->get()->keyBy(function ($item) {
            return \Carbon\Carbon::parse($item->travel_date)->format('Y-m-d');
        });

        return view('admin.tours.calendar', compact('tour', 'schedules'));
    }

    // สลับสถานะ ว่าง (เขียว) ⇄ เต็ม/ปิดรับ (แดง) ทันที
    public function toggleDate(Request $request, Tour $tour)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $date = $request->date;
        $schedule = TourSchedule::where('tour_id', $tour->id)
            ->where('travel_date', $date)
            ->first();

        if ($schedule) {
            // สลับสถานะ: ถ้าว่างอยู่ -> เปลี่ยนเป็นเต็ม/ปิดรับ (false) / ถ้าปิดอยู่ -> เปลี่ยนเป็นว่าง (true)
            $schedule->is_available = !$schedule->is_available;
            $schedule->save();
        } else {
            // ถ้ายังไม่มีวันในระบบ -> สร้างใหม่เป็นสถานะ "เต็ม/ไม่ว่าง" (แดง)
            $schedule = TourSchedule::create([
                'tour_id' => $tour->id,
                'travel_date' => $date,
                'available_seats' => 20,
                'is_available' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'date' => $date,
            'is_available' => $schedule->is_available,
            'seats' => $schedule->available_seats,
        ]);
    }

    // กำหนดจำนวนที่นั่ง
    public function updateSeats(Request $request, Tour $tour)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'seats' => 'required|integer|min:0|max:200',
        ]);

        $schedule = TourSchedule::updateOrCreate(
            ['tour_id' => $tour->id, 'travel_date' => $request->date],
            ['available_seats' => $request->seats, 'is_available' => $request->seats > 0]
        );

        return response()->json([
            'success' => true,
            'date' => $request->date,
            'is_available' => $schedule->is_available,
            'seats' => $schedule->available_seats,
        ]);
    }
}