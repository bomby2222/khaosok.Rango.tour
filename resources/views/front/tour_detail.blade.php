@extends('layouts.app')

@section('title', $tour->title . ' - Rango Tour')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="tourBookingCalendar()">
    
    <!-- Cover Image & Header Banner -->
    <div class="bg-neutral-900 rounded-3xl sm:rounded-[2.5rem] overflow-hidden shadow-2xl border border-neutral-800 mb-8">
        <div class="relative h-80 sm:h-96 md:h-[480px] w-full overflow-hidden bg-neutral-950">
            <img src="{{ asset('storage/' . $tour->cover_image) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/20 to-transparent"></div>
            
            <div class="absolute top-6 left-6">
                <span class="bg-emerald-500 text-neutral-950 text-xs px-4 py-1.5 rounded-full font-black uppercase tracking-wider shadow-lg shadow-emerald-500/20">
                    📍 {{ $tour->location }}
                </span>
            </div>

            <div class="absolute bottom-6 left-6 right-6 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-mono-code text-emerald-400 font-bold uppercase tracking-wider block mb-1">
                        ⏱️ Duration: {{ $tour->duration_days }} Days {{ $tour->duration_nights }} Nights
                    </span>
                    <h1 class="text-2xl sm:text-4xl md:text-5xl font-black text-white leading-tight">{{ $tour->title }}</h1>
                </div>

                <div class="bg-black/70 backdrop-blur-md px-5 py-3 rounded-2xl border border-neutral-800">
                    <span class="text-[10px] font-mono-code text-neutral-400 block uppercase">Price / Person</span>
                    <span class="text-3xl sm:text-4xl font-black text-emerald-400 font-mono-code">฿{{ number_format($tour->price) }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <p class="text-neutral-300 leading-relaxed text-sm sm:text-base">{{ $tour->description }}</p>
        </div>
    </div>

    <!-- 2 Column Details & Interactive Calendar Booking -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left 7 Cols: Itinerary & Inclusions -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Itinerary -->
            <div class="bg-neutral-900 p-6 sm:p-8 rounded-3xl shadow-xl border border-neutral-800">
                <h3 class="text-base sm:text-lg font-black text-white mb-4 border-b border-neutral-800 pb-3 uppercase tracking-wider flex items-center gap-2">
                    <span>🧭</span> Detailed Daily Itinerary
                </h3>
                <div class="text-neutral-300 text-xs sm:text-sm whitespace-pre-line leading-relaxed font-mono-code">{!! nl2br(e($tour->itinerary)) !!}</div>
            </div>

            <!-- Inclusions vs Exclusions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-emerald-950/20 p-5 rounded-2xl border border-emerald-500/20 space-y-2">
                    <h4 class="font-bold text-emerald-400 text-xs sm:text-sm uppercase flex items-center gap-1.5">
                        <span>✅</span> Included in Package
                    </h4>
                    <div class="text-xs text-emerald-200/90 whitespace-pre-line leading-relaxed font-mono-code">{!! nl2br(e($tour->included)) !!}</div>
                </div>
                <div class="bg-rose-950/20 p-5 rounded-2xl border border-rose-500/20 space-y-2">
                    <h4 class="font-bold text-rose-400 text-xs sm:text-sm uppercase flex items-center gap-1.5">
                        <span>❌</span> Excluded / Optional Fees
                    </h4>
                    <div class="text-xs text-rose-200/90 whitespace-pre-line leading-relaxed font-mono-code">{!! nl2br(e($tour->excluded)) !!}</div>
                </div>
            </div>
        </div>

        <!-- Right 5 Cols: Interactive Calendar Booking Box -->
        <div class="lg:col-span-5">
            <div class="bg-neutral-900 p-6 sm:p-7 rounded-3xl shadow-2xl border border-neutral-800 static lg:sticky lg:top-28 space-y-5">
                
                <div>
                    <h3 class="text-base font-black text-white uppercase tracking-wider">Book This Tour</h3>
                    <p class="text-xs text-neutral-400 mt-0.5">Select an available travel date from the calendar.</p>
                </div>

                <!-- Interactive Monthly Calendar -->
                <div class="bg-neutral-950 p-4 rounded-2xl border border-neutral-800">
                    
                    <!-- Month Header & Controls -->
                    <div class="flex items-center justify-between mb-4 pb-2 border-b border-neutral-800 text-xs font-mono-code">
                        <button type="button" @click="prevMonth()" class="px-2.5 py-1 rounded-lg bg-neutral-900 hover:bg-neutral-800 text-white transition">&larr;</button>
                        <span class="font-bold text-white uppercase tracking-wider" x-text="monthNames[currentMonth] + ' ' + currentYear"></span>
                        <button type="button" @click="nextMonth()" class="px-2.5 py-1 rounded-lg bg-neutral-900 hover:bg-neutral-800 text-white transition">&rarr;</button>
                    </div>

                    <!-- Days of Week Header -->
                    <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-mono-code font-bold uppercase text-neutral-500 mb-2">
                        <span class="text-rose-400">Su</span>
                        <span>Mo</span>
                        <span>Tu</span>
                        <span>We</span>
                        <span>Th</span>
                        <span>Fr</span>
                        <span class="text-emerald-400">Sa</span>
                    </div>

                    <!-- Calendar Days Grid -->
                    <div class="grid grid-cols-7 gap-1.5">
                        <template x-for="b in firstDayIndex" :key="'blank-' + b">
                            <div class="h-10 rounded-xl opacity-0"></div>
                        </template>

                        <template x-for="day in totalDaysInMonth" :key="'day-' + day">
                            <button type="button" 
                                    @click="selectDate(day)"
                                    :disabled="!isDateSelectable(day)"
                                    :class="getDayButtonClass(day)"
                                    class="h-11 rounded-xl text-xs font-mono-code font-bold flex flex-col items-center justify-center transition-all duration-200 relative group select-none">
                                <span x-text="day"></span>
                                <template x-if="isDateAvailable(day) && !isPast(day)">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mt-0.5"></span>
                                </template>
                                <template x-if="isDateFull(day) && !isPast(day)">
                                    <span class="text-[7px] text-rose-300 font-extrabold uppercase leading-none mt-0.5">FULL</span>
                                </template>
                            </button>
                        </template>
                    </div>

                    <!-- Legend -->
                    <div class="mt-4 pt-3 border-t border-neutral-800 flex items-center justify-between text-[10px] font-mono-code text-neutral-400">
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> ว่าง (Open)</span>
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-500"></span> เต็ม (Full)</span>
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-neutral-700"></span> ปิดรับ</span>
                    </div>
                </div>

                <!-- Selected Date Display Feedback -->
                <div class="bg-black/60 p-3.5 rounded-xl border border-neutral-800 text-xs font-mono-code">
                    <span class="text-neutral-400 block text-[10px] uppercase">Selected Departure Date:</span>
                    <template x-if="selectedDate">
                        <div class="flex items-center justify-between mt-1">
                            <span class="font-bold text-emerald-400 text-sm" x-text="formatDisplayDate(selectedDate)"></span>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-md font-bold" x-text="selectedSeats + ' seats left'"></span>
                        </div>
                    </template>
                    <template x-if="!selectedDate">
                        <span class="text-neutral-500 italic mt-1 block">Please click a green date on the calendar</span>
                    </template>
                </div>

                <!-- Number of Travelers -->
                <div>
                    <label class="block text-xs font-semibold text-neutral-300 mb-1.5 uppercase tracking-wider font-mono-code">Number of Travelers</label>
                    <div class="flex items-center gap-3">
                        <button type="button" @click="if(travelersCount > 1) travelersCount--" class="w-11 h-11 rounded-xl bg-neutral-950 border border-neutral-800 text-white font-bold text-lg hover:bg-neutral-800 transition">-</button>
                        <input type="number" x-model.number="travelersCount" min="1" max="50" class="flex-grow bg-neutral-950 text-white text-center font-bold font-mono-code border border-neutral-800 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <button type="button" @click="travelersCount++" class="w-11 h-11 rounded-xl bg-neutral-950 border border-neutral-800 text-white font-bold text-lg hover:bg-neutral-800 transition">+</button>
                    </div>
                </div>

                <!-- Total Calculation -->
                <div class="border-t border-neutral-800 pt-4 flex justify-between items-baseline">
                    <span class="text-xs text-neutral-400 font-mono-code uppercase">Estimated Total:</span>
                    <span class="text-3xl font-black text-emerald-400 font-mono-code">฿<span x-text="totalPriceFormatted"></span></span>
                </div>

                <!-- Instant Booking Trigger Button -->
                <button type="button" 
                        @click="openModal()" 
                        class="w-full bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black uppercase tracking-wider py-4 px-4 rounded-2xl shadow-xl shadow-emerald-500/20 text-xs transition duration-200 flex items-center justify-center gap-2 hover:scale-[1.02] active:scale-95">
                    <span>⚡</span> Instant Booking
                </button>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         BOOKING CHANNEL MODAL (เพิ่มปุ่มแชทสดในเว็บ + LINE + WhatsApp)
         ========================================================================= -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md px-4">
        <div @click.away="showModal = false" class="bg-neutral-900 border border-neutral-800 rounded-3xl max-w-md w-full p-6 sm:p-7 text-center shadow-2xl relative">
            <h3 class="text-lg sm:text-xl font-black text-white mb-1 uppercase tracking-wider">SELECT BOOKING CHANNEL</h3>
            <p class="text-xs text-neutral-400 mb-5">Your booking summary will be formatted automatically.</p>

            <!-- Pre-formatted Booking Card -->
            <div class="bg-black/70 p-4 rounded-2xl text-left text-xs mb-5 border border-neutral-800 space-y-2 font-mono-code shadow-inner">
                <p class="font-bold text-white text-sm leading-tight">{{ $tour->title }}</p>
                <p class="text-neutral-300">🗓️ Date: <span class="font-bold text-emerald-400" x-text="formatDisplayDate(selectedDate)"></span></p>
                <p class="text-neutral-300">👥 Travelers: <span class="font-bold text-white" x-text="travelersCount + ' persons'"></span></p>
                <p class="text-neutral-300">💰 Total Price: <span class="font-bold text-emerald-400">฿<span x-text="totalPriceFormatted"></span></span></p>
            </div>

            <!-- 3 Channel Action Buttons -->
            <div class="space-y-3">
                <!-- 1. ปุ่มแชทสดในเว็บ (In-Website Live Chat) -->
                <button @click="proceedBooking('webchat')" class="w-full bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 text-xs uppercase tracking-wider transition shadow-lg shadow-emerald-500/25 hover:scale-[1.02] active:scale-95">
                    <span>💬</span> Chat via Website (แชทสดในเว็บ)
                </button>

                <!-- 2. LINE Official -->
                <button @click="proceedBooking('line')" class="w-full bg-[#06C755] hover:bg-[#05b34c] text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 text-xs transition shadow-lg hover:scale-[1.02] active:scale-95">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 5.92 2 10.75c0 4.29 3.55 7.89 8.35 8.58.36.08.86.24.98.55.11.28.07.72.03 1-.06.4-.3 1.63-.33 1.83-.05.3-.23 1.17 1.03.64 1.25-.53 6.78-4 9.25-6.86C23.01 14.39 24 12.63 24 10.75 24 5.92 19.52 2 12 2z"/></svg>
                    <span>Contact via LINE Official</span>
                </button>

                <!-- 3. WhatsApp -->
                <button @click="proceedBooking('whatsapp')" class="w-full bg-[#25D366] hover:bg-[#20ba59] text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 text-xs transition shadow-lg hover:scale-[1.02] active:scale-95">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Contact via WhatsApp</span>
                </button>
            </div>

            <button @click="showModal = false" class="mt-4 text-xs text-neutral-500 hover:text-neutral-300 font-mono-code transition">Cancel</button>
        </div>
    </div>
</div>

<script>
    function tourBookingCalendar() {
        return {
            pricePerPerson: {{ $tour->price }},
            travelersCount: 1,
            selectedDate: null,
            selectedSeats: 20,
            showModal: false,
            currentYear: new Date().getFullYear(),
            currentMonth: new Date().getMonth(),
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            schedulesMap: @json($tour->schedules->keyBy(function($item) { return \Carbon\Carbon::parse($item->travel_date)->format('Y-m-d'); })),
            lineId: "{{ $settings['line_id'] ?? '@rangotour' }}",
            whatsappPhone: "{{ $settings['whatsapp_number'] ?? '66812345678' }}",

            get totalPrice() {
                return this.travelersCount * this.pricePerPerson;
            },

            get totalPriceFormatted() {
                return new Intl.NumberFormat('en-US').format(this.totalPrice);
            },

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

            isPast(day) {
                const dateStr = this.getDateString(day);
                const today = new Date();
                today.setHours(0,0,0,0);
                return new Date(dateStr) < today;
            },

            isDateAvailable(day) {
                const dateStr = this.getDateString(day);
                if (this.schedulesMap[dateStr] !== undefined) {
                    return this.schedulesMap[dateStr].is_available && this.schedulesMap[dateStr].available_seats > 0;
                }
                return true;
            },

            isDateFull(day) {
                const dateStr = this.getDateString(day);
                if (this.schedulesMap[dateStr] !== undefined) {
                    return !this.schedulesMap[dateStr].is_available || this.schedulesMap[dateStr].available_seats <= 0;
                }
                return false;
            },

            isDateSelectable(day) {
                return !this.isPast(day) && this.isDateAvailable(day);
            },

            getDayButtonClass(day) {
                const dateStr = this.getDateString(day);
                const isSelected = this.selectedDate === dateStr;

                if (this.isPast(day)) {
                    return 'bg-neutral-900/40 text-neutral-600 border border-neutral-900 cursor-not-allowed';
                }

                if (isSelected) {
                    return 'bg-emerald-500 text-black font-black border-emerald-400 shadow-lg shadow-emerald-500/40 scale-105 z-10';
                }

                if (this.isDateFull(day)) {
                    return 'bg-rose-950/50 text-rose-400 border border-rose-900/60 cursor-not-allowed';
                }

                return 'bg-emerald-950/30 text-emerald-300 border border-emerald-500/30 hover:border-emerald-400 hover:bg-emerald-900/50 cursor-pointer';
            },

            selectDate(day) {
                if (!this.isDateSelectable(day)) return;
                const dateStr = this.getDateString(day);
                this.selectedDate = dateStr;

                if (this.schedulesMap[dateStr] !== undefined) {
                    this.selectedSeats = this.schedulesMap[dateStr].available_seats;
                } else {
                    this.selectedSeats = 20;
                }
            },

            formatDisplayDate(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            },

            openModal() {
                if (!this.selectedDate) {
                    alert('กรุณาคลิกเลือกวันเดินทาง (สีเขียว 🟢) บนปฏิทินก่อนครับ');
                    return;
                }
                this.showModal = true;
            },

            proceedBooking(channel) {
                const message = `📋 สนใจจองทัวร์ (Booking Inquiry):\n` +
                              `📍 โปรแกรม: {{ $tour->title }}\n` +
                              `🗓️ วันที่เดินทาง: ${this.formatDisplayDate(this.selectedDate)}\n` +
                              `👥 จำนวนผู้เดินทาง: ${this.travelersCount} ท่าน\n` +
                              `💰 ราคารวมโดยประมาณ: ฿${this.totalPriceFormatted}\n` +
                              `🔗 หน้าทัวร์: ${window.location.href}`;

                if (channel === 'webchat') {
                    this.showModal = false;
                    // ส่งข้อมูลการจองไปยังกล่องแชทสดของเว็บไซต์ทันที
                    window.dispatchEvent(new CustomEvent('open-rango-chat', {
                        detail: { message: message }
                    }));
                } else if (channel === 'line') {
                    const encodedMsg = encodeURIComponent(message);
                    window.open(`https://line.me/R/oaMessage/${this.lineId}/?${encodedMsg}`, '_blank');
                } else if (channel === 'whatsapp') {
                    const encodedMsg = encodeURIComponent(message);
                    window.open(`https://wa.me/${this.whatsappPhone}?text=${encodedMsg}`, '_blank');
                }
            }
        }
    }
</script>
@endsection