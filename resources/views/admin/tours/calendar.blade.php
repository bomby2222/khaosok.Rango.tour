@extends('layouts.admin')

@section('title', 'CALENDAR MANAGER // ' . $tour->title)
@section('header', 'TOUR AVAILABILITY CALENDAR')

@section('content')
<div class="space-y-6" x-data="adminCalendarManager()">
    
    <!-- Top Bar -->
    <div class="glass-panel p-6 rounded-3xl border border-emerald-500/20 shadow-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.tours.index') }}" class="text-xs font-mono-code text-emerald-400 hover:text-emerald-300 flex items-center gap-1 mb-1">
                <span>&larr;</span> Back to Tours
            </a>
            <h2 class="text-xl font-black text-white uppercase">{{ $tour->title }}</h2>
            <p class="text-xs text-zinc-400 font-mono-code mt-0.5">Click any date on the calendar below to toggle between Available (Green 🟢) and Full/Blocked (Red 🔴).</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-black/60 px-4 py-2 rounded-2xl border border-zinc-800 text-xs font-mono-code">
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                <span class="text-zinc-300">Available (ว่าง)</span>
                <span class="text-zinc-600 mx-1">|</span>
                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                <span class="text-zinc-300">Full/Blocked (เต็ม/ปิดรับ)</span>
            </div>
        </div>
    </div>

    <!-- Calendar Interactive Board -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-emerald-500/15 shadow-2xl">
        <!-- Month Navigation -->
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-zinc-800">
            <button @click="prevMonth()" class="px-4 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-mono-code font-bold transition flex items-center gap-2">
                <span>&larr;</span> Previous
            </button>

            <h3 class="text-lg font-black text-white uppercase tracking-wider font-mono-code" x-text="monthNames[currentMonth] + ' ' + currentYear"></h3>

            <button @click="nextMonth()" class="px-4 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-mono-code font-bold transition flex items-center gap-2">
                Next <span>&rarr;</span>
            </button>
        </div>

        <!-- Days of Week Header -->
        <div class="grid grid-cols-7 gap-2 mb-3 text-center text-[11px] font-mono-code font-bold uppercase text-zinc-400">
            <span class="text-rose-400">Sun</span>
            <span>Mon</span>
            <span>Tue</span>
            <span>Wed</span>
            <span>Thu</span>
            <span>Fri</span>
            <span class="text-emerald-400">Sat</span>
        </div>

        <!-- Calendar Days Grid -->
        <div class="grid grid-cols-7 gap-2 sm:gap-3">
            <!-- Leading Blank Days -->
            <template x-for="b in firstDayIndex" :key="'blank-' + b">
                <div class="h-20 sm:h-24 rounded-2xl bg-black/20 border border-transparent opacity-20"></div>
            </template>

            <!-- Actual Month Days -->
            <template x-for="day in totalDaysInMonth" :key="'day-' + day">
                <div @click="toggleDayStatus(day)" 
                     :class="getDayClass(day)"
                     class="h-20 sm:h-24 p-2 sm:p-2.5 rounded-2xl border transition-all duration-200 cursor-pointer flex flex-col justify-between select-none relative group hover:scale-[1.02]">
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs sm:text-sm font-black font-mono-code" x-text="day"></span>
                        <span class="text-[9px] font-mono-code font-bold uppercase px-1.5 py-0.5 rounded"
                              :class="isDateAvailable(day) ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300'"
                              x-text="isDateAvailable(day) ? '🟢 ว่าง' : '🔴 เต็ม'">
                        </span>
                    </div>

                    <div class="text-[10px] font-mono-code mt-1">
                        <span class="text-zinc-400" x-text="getSeatsCount(day) + ' seats'"></span>
                    </div>

                    <div class="text-[9px] font-mono-code text-zinc-500 opacity-0 group-hover:opacity-100 transition text-right">
                        Click to toggle ⇄
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    function adminCalendarManager() {
        return {
            tourId: {{ $tour->id }},
            currentYear: new Date().getFullYear(),
            currentMonth: new Date().getMonth(),
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            schedulesMap: @json($schedules),

            get firstDayIndex() {
                return new Date(this.currentYear, this.currentMonth, 1).getDay();
            },

            get totalDaysInMonth() {
                return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            },

            prevMonth() {
                if (this.currentMonth === 0) {
                    this.currentMonth = 11;
                    this.currentYear--;
                } else {
                    this.currentMonth--;
                }
            },

            nextMonth() {
                if (this.currentMonth === 11) {
                    this.currentMonth = 0;
                    this.currentYear++;
                } else {
                    this.currentMonth++;
                }
            },

            getDateString(day) {
                const m = String(this.currentMonth + 1).padStart(2, '0');
                const d = String(day).padStart(2, '0');
                return `${this.currentYear}-${m}-${d}`;
            },

            isDateAvailable(day) {
                const dateStr = this.getDateString(day);
                if (this.schedulesMap[dateStr] !== undefined) {
                    return this.schedulesMap[dateStr].is_available;
                }
                return true; // Default เป็นว่าง (เขียว)
            },

            getSeatsCount(day) {
                const dateStr = this.getDateString(day);
                if (this.schedulesMap[dateStr] !== undefined) {
                    return this.schedulesMap[dateStr].available_seats;
                }
                return 20;
            },

            getDayClass(day) {
                const isAvail = this.isDateAvailable(day);
                if (isAvail) {
                    return 'bg-emerald-950/30 border-emerald-500/40 text-emerald-300 hover:border-emerald-400 hover:shadow-lg hover:shadow-emerald-500/20';
                } else {
                    return 'bg-rose-950/40 border-rose-600/50 text-rose-300 hover:border-rose-500 hover:shadow-lg hover:shadow-rose-500/20';
                }
            },

            toggleDayStatus(day) {
                const dateStr = this.getDateString(day);

                fetch(`/rango-admin/tours/${this.tourId}/calendar/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ date: dateStr })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.schedulesMap[dateStr] = {
                            is_available: data.is_available,
                            available_seats: data.seats
                        };
                    }
                })
                .catch(err => console.error(err));
            }
        }
    }
</script>
@endsection