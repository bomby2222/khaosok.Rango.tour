<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourSchedule;
use App\Models\Resort;
use App\Models\Review;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. สถิติทัวร์จริง
        $totalTours = Tour::count();
        $activeTours = Tour::where('status', true)->count();
        $allTours = Tour::latest()->get();

        // 2. สถิติแชทจริง
        $totalInquiries = 0;
        if (class_exists(ChatSession::class)) {
            $totalInquiries = ChatSession::count();
        } elseif (class_exists(ChatMessage::class)) {
            $totalInquiries = ChatMessage::where('sender', 'user')->count();
        }

        $lastWeekInquiries = 0;
        if (class_exists(ChatSession::class)) {
            $lastWeekInquiries = ChatSession::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        } elseif (class_exists(ChatMessage::class)) {
            $lastWeekInquiries = ChatMessage::where('sender', 'user')->where('created_at', '>=', Carbon::now()->subDays(7))->count();
        }

        // 3. สถิติรีวิวจริง
        $totalReviews = Review::count();
        $avgRating = $totalReviews > 0 ? round(Review::avg('rating'), 1) : 5.0;
        $fiveStarCount = Review::where('rating', 5)->count();
        $fiveStarPercent = $totalReviews > 0 ? round(($fiveStarCount / $totalReviews) * 100) : 100;
        $recentReviews = Review::latest()->take(5)->get();

        // 4. สถิติแพที่พักและที่นั่งว่างจริง
        $resorts = Resort::where('status', true)->orderBy('sort_order', 'asc')->get();
        $totalResorts = $resorts->count();
        
        $totalSeatsAvailable = TourSchedule::where('travel_date', '>=', Carbon::today())
            ->where('is_available', true)
            ->sum('available_seats');
            
        if ($totalSeatsAvailable == 0) {
            $totalSeatsAvailable = TourSchedule::sum('available_seats') ?: 0;
        }

        // 5. ข้อมูลกราฟจริง (7 วัน, 30 วัน, 1 ปี)
        $chart7DaysLabels = [];
        $chart7DaysData = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i);
            $chart7DaysLabels[] = $d->format('D (d M)');
            $count = 0;
            if (class_exists(ChatSession::class)) {
                $count = ChatSession::whereDate('created_at', $d)->count();
            } elseif (class_exists(ChatMessage::class)) {
                $count = ChatMessage::where('sender', 'user')->whereDate('created_at', $d)->count();
            }
            $chart7DaysData[] = $count;
        }

        $chart30DaysLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        $chart30DaysData = [
            class_exists(ChatSession::class) ? ChatSession::whereBetween('created_at', [Carbon::today()->subDays(28), Carbon::today()->subDays(21)])->count() : 0,
            class_exists(ChatSession::class) ? ChatSession::whereBetween('created_at', [Carbon::today()->subDays(21), Carbon::today()->subDays(14)])->count() : 0,
            class_exists(ChatSession::class) ? ChatSession::whereBetween('created_at', [Carbon::today()->subDays(14), Carbon::today()->subDays(7)])->count() : 0,
            class_exists(ChatSession::class) ? ChatSession::whereBetween('created_at', [Carbon::today()->subDays(7), Carbon::today()])->count() : 0,
        ];

        $chartYearLabels = [];
        $chartYearData = [];
        for ($m = 11; $m >= 0; $m--) {
            $monthDate = Carbon::today()->subMonths($m);
            $chartYearLabels[] = $monthDate->format('M Y');
            $count = 0;
            if (class_exists(ChatSession::class)) {
                $count = ChatSession::whereMonth('created_at', $monthDate->month)->whereYear('created_at', $monthDate->year)->count();
            } elseif (class_exists(ChatMessage::class)) {
                $count = ChatMessage::where('sender', 'user')->whereMonth('created_at', $monthDate->month)->whereYear('created_at', $monthDate->year)->count();
            }
            $chartYearData[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalTours',
            'activeTours',
            'allTours',
            'totalInquiries',
            'lastWeekInquiries',
            'totalReviews',
            'avgRating',
            'fiveStarPercent',
            'recentReviews',
            'resorts',
            'totalResorts',
            'totalSeatsAvailable',
            'chart7DaysLabels',
            'chart7DaysData',
            'chart30DaysLabels',
            'chart30DaysData',
            'chartYearLabels',
            'chartYearData'
        ));
    }

    public function flushCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');

        return redirect()->route('admin.dashboard')->with('success', 'System Cache Flushed Successfully.');
    }
}