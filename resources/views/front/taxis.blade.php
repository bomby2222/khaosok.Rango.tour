@extends('layouts.app')

@section('title', 'Khao Sok VIP Taxi & Transfers - Private & Shared Fleet')

@section('content')

<div class="py-10 sm:py-14 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10"  
     x-data="{  
        openZone: '{{ $selectedZone ?? 'phuket' }}', 
        activeRouteId: null, 
        toggleRoute(id) { 
            this.activeRouteId = (this.activeRouteId === id) ? null : id; 
        } 
     }"> 

```
{{-- ========================================================= --}} 
{{-- HERO HEADER --}} 
{{-- ========================================================= --}} 
<div class="text-center max-w-3xl mx-auto space-y-3"> 
    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-mono-code font-bold uppercase tracking-widest"> 
        🚕 Cross-Province VIP Transfers 
    </div> 
    <h1 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white"> 
        Taxi &amp; Private <span class="text-emerald-400">Transfers</span> 
    </h1> 
    <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed max-w-2xl mx-auto"> 
        VIP private transfer services connecting Phuket, Khao Sok, Phang Nga, and Krabi. Select your travel date, pickup time, and number of passengers to check the price and book instantly via Live Chat. 
    </p> 
</div> 

@php 
    $zones = [ 
        'phuket' => [ 
            'name' => 'Phuket', 
            'subtitle' => 'PHUKET', 
            'icon' => '🏝️', 
            'description' => 'Airport transfers, hotel pickups, Patong, and destinations throughout Phuket.', 
            'color' => 'blue', 
        ], 
        'khaosok' => [ 
            'name' => 'Khao Sok', 
            'subtitle' => 'KHAO SOK', 
            'icon' => '🛶', 
            'description' => 'Transfers to Khao Sok National Park, Cheow Lan Lake Pier, and floating raft resorts.', 
            'color' => 'emerald', 
        ], 
        'phangnga' => [ 
            'name' => 'Phang Nga', 
            'subtitle' => 'PHANG NGA', 
            'icon' => '⛰️', 
            'description' => 'Transfers to Khao Lak, Samet Nangshe, Ban Nam Khem Pier, and attractions throughout Phang Nga.', 
            'color' => 'teal', 
        ], 
        'krabi' => [ 
            'name' => 'Krabi', 
            'subtitle' => 'KRABI', 
            'icon' => '🏖️', 
            'description' => 'Transfers from Krabi Airport, Ao Nang, Klong Muang Beach, and famous destinations in Krabi.', 
            'color' => 'amber', 
        ], 
    ]; 
@endphp 

{{-- ========================================================= --}} 
{{-- ACCORDION ZONES LIST --}} 
{{-- ========================================================= --}} 
<div class="space-y-4"> 
    @foreach($zones as $zoneKey => $zone) 
        @php 
            $zoneTaxis = $taxis->where('zone', $zoneKey); 
        @endphp 

        <div class="rounded-3xl overflow-hidden bg-neutral-900/80 border border-neutral-800 transition-all duration-300" 
             :class="openZone === '{{ $zoneKey }}' ? 'border-{{ $zone['color'] }}-500/40 shadow-xl shadow-{{ $zone['color'] }}-500/5' : ''"> 

            {{-- DROPDOWN HEADER --}} 
            <button type="button" 
                    @click="openZone = openZone === '{{ $zoneKey }}' ? null : '{{ $zoneKey }}'" 
                    class="w-full p-5 sm:p-6 flex items-center justify-between text-left hover:bg-white/[0.02] transition"> 

                <div class="flex items-center gap-4"> 
                    {{-- ICON --}} 
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-{{ $zone['color'] }}-500/10 border border-{{ $zone['color'] }}-500/20 flex items-center justify-center text-2xl sm:text-3xl"> 
                        {{ $zone['icon'] }} 
                    </div> 

                    {{-- TITLE --}} 
                    <div> 
                        <div class="text-[9px] sm:text-[10px] tracking-[0.2em] font-black text-{{ $zone['color'] }}-400 font-mono-code"> 
                            {{ $zone['subtitle'] }} 
                        </div> 
                        <h2 class="text-xl sm:text-2xl font-black text-white"> 
                            {{ $zone['name'] }} Zone 
                        </h2> 
                        <p class="hidden sm:block text-xs text-neutral-500 mt-1"> 
                            {{ $zone['description'] }} 
                        </p> 
                    </div> 
                </div> 

                {{-- RIGHT SIDE --}} 
                <div class="flex items-center gap-3 ml-3"> 
                    <span class="hidden sm:inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-black/30 border border-neutral-800 text-[10px] font-mono-code font-bold text-neutral-400"> 
                        <span class="w-2 h-2 rounded-full bg-{{ $zone['color'] }}-400"></span> 
                        {{ $zoneTaxis->count() }} Routes 
                    </span> 

                    {{-- CHEVRON --}} 
                    <div class="w-9 h-9 rounded-xl bg-black/30 border border-neutral-800 flex items-center justify-center text-neutral-400 transition-transform duration-300" 
                         :class="openZone === '{{ $zoneKey }}' ? 'rotate-180 text-white' : ''"> 
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> 
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/> 
                        </svg> 
                    </div> 
                </div> 
            </button> 

            {{-- DROPDOWN CONTENT --}} 
            <div x-show="openZone === '{{ $zoneKey }}'" x-collapse x-cloak> 
                <div class="px-5 pb-5 sm:px-6 sm:pb-6 space-y-4"> 
                     
                    {{-- MOBILE DESCRIPTION --}} 
                    <div class="sm:hidden mb-4 px-4 py-3 rounded-2xl bg-black/20 border border-neutral-800"> 
                        <p class="text-xs text-neutral-500 leading-relaxed"> 
                            {{ $zone['description'] }} 
                        </p> 
                    </div> 

                    {{-- ROUTES LIST --}} 
                    @if($zoneTaxis->count() > 0) 
                        <div class="space-y-4"> 
                            @foreach($zoneTaxis as $taxi) 
                                @php 
                                    $routeName = !empty($taxi->route_name)  
                                        ? $taxi->route_name  
                                        : (($taxi->from_location ?? '') . (!empty($taxi->to_location) ? ' ➔ ' . $taxi->to_location : 'Transfer Route')); 
                                    $scheduleTime = $taxi->pickup_times ?? $taxi->schedule_times ?? 'On-Demand 24/7'; 
                                     
                                    $charterPrice = (float) $taxi->price; 
                                    $perPersonPrice = (float) ($taxi->price_per_person ?? 0); 
                                @endphp 

                                <div x-data="{ 
                                        bookingType: '{{ $perPersonPrice > 0 ? 'per_person' : 'charter' }}', 
                                        travelDate: new Date().toISOString().split('T')[0], 
                                        pickupTime: '{{ explode(',', $scheduleTime)[0] ?? '09:00' }}', 
                                        paxCount: 2, 
                                        charterRate: {{ $charterPrice }}, 
                                        personRate: {{ $perPersonPrice }}, 
                                        calculateTotal() { 
                                            if (this.bookingType === 'per_person' && this.personRate > 0) { 
                                                return this.personRate * this.paxCount; 
                                            } 
                                            return this.charterRate; 
                                        }, 
                                        sendBookingToChat() { 
                                            const typeLabel = (this.bookingType === 'per_person') ? 'Shared (Per Person)' : 'Private Charter'; 
                                            const total = this.calculateTotal().toLocaleString(); 
                                            const message = `🚕 Booking Request: {{ addslashes($routeName) }}\n` + 
                                                            `• Zone: {{ strtoupper($taxi->zone) }}\n` + 
                                                            `• Booking Type: ${typeLabel}\n` + 
                                                            `• Travel Date: ${this.travelDate}\n` + 
                                                            `• Pickup Time: ${this.pickupTime}\n` + 
                                                            `• Passengers: ${this.paxCount}\n` + 
                                                            `• Vehicle: {{ addslashes($taxi->vehicle_type) }}\n` + 
                                                            `• Estimated Total: ฿${total}`; 
                                             
                                            $dispatch('open-rango-chat', { message: message }); 
                                        } 
                                     }" 
                                     class="rounded-2xl bg-black/30 border border-neutral-800 transition-all duration-300 overflow-hidden" 
                                     :class="activeRouteId === {{ $taxi->id }} ? 'border-emerald-500/50 shadow-xl' : 'hover:border-neutral-700'"> 

                                    {{-- MAIN ROW HEADER --}} 
                                    <div class="p-5 cursor-pointer select-none" @click="toggleRoute({{ $taxi->id }})"> 
                                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5"> 
                                             
                                            <div class="flex items-start gap-3.5 flex-grow"> 
                                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-base shrink-0 mt-0.5"> 
                                                    📍 
                                                </div> 

                                                <div class="space-y-1 flex-grow"> 
                                                    <div class="flex flex-wrap items-center gap-2"> 
                                                        <span class="text-xs font-mono-code text-zinc-400 font-bold">🚗 {{ $taxi->vehicle_type }}</span> 
                                                        <span class="text-xs font-mono-code text-zinc-500">• ⏱️ {{ $taxi->duration ?: 'Based on Distance' }}</span> 
                                                    </div> 

                                                    <h3 class="text-sm sm:text-base font-black text-white leading-snug"> 
                                                        {{ $routeName }} 
                                                    </h3> 

                                                    @if(!empty($taxi->from_location) && !empty($taxi->to_location) && !empty($taxi->route_name)) 
                                                        <div class="text-[11px] font-mono-code text-zinc-400 flex items-center gap-1.5"> 
                                                            <span>{{ $taxi->from_location }}</span> 
                                                            <span class="text-emerald-400">➔</span> 
                                                            <span>{{ $taxi->to_location }}</span> 
                                                        </div> 
                                                    @endif 
                                                </div> 
                                            </div> 

                                            <div class="flex items-center justify-between lg:justify-end gap-6 border-t lg:border-t-0 border-neutral-800/80 pt-3 lg:pt-0 shrink-0"> 
                                                <div class="text-left lg:text-right"> 
                                                    <span class="text-[9px] font-mono-code uppercase text-zinc-500 block">Starting Price</span> 
                                                    <div class="flex items-baseline gap-1.5"> 
                                                        <span class="text-lg sm:text-xl font-black font-mono-code text-emerald-400">฿{{ number_format($charterPrice) }}</span> 
                                                        <span class="text-[11px] text-zinc-500 font-mono-code">/ Private Charter</span> 
                                                    </div> 
                                                    @if($perPersonPrice > 0) 
                                                        <span class="text-[11px] font-mono-code text-teal-400 font-bold block"> 
                                                            Or ฿{{ number_format($perPersonPrice) }} <span class="text-[9px] text-zinc-500 font-normal">/ person</span> 
                                                        </span> 
                                                    @endif 
                                                </div> 

                                                <button type="button"  
                                                        class="px-4 py-2.5 rounded-xl bg-neutral-800 hover:bg-emerald-500 text-white hover:text-neutral-950 font-black text-xs font-mono-code uppercase tracking-wider transition flex items-center gap-1.5" 
                                                        :class="activeRouteId === {{ $taxi->id }} ? 'bg-emerald-500 text-neutral-950' : ''"> 
                                                    <span x-text="activeRouteId === {{ $taxi->id }} ? 'Close Options' : 'Select Date &amp; Book'"></span> 
                                                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="activeRouteId === {{ $taxi->id }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/> 
                                                    </svg> 
                                                </button> 
                                            </div> 

                                        </div> 
                                    </div> 

                                    {{-- EXPANDABLE DRAWER --}} 
                                    <div x-show="activeRouteId === {{ $taxi->id }}"  
                                         x-collapse  
                                         x-cloak  
                                         class="border-t border-neutral-800/80 bg-neutral-950/60 p-5 sm:p-6 space-y-6"> 
                                         
                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6"> 
                                             
                                            {{-- SPECS & INCLUSIONS --}} 
                                            <div class="lg:col-span-6 space-y-5"> 
                                                @if(!empty($taxi->description)) 
                                                    <div> 
                                                        <h4 class="text-[11px] font-bold uppercase tracking-wider text-emerald-400 font-mono-code mb-1.5"> 
                                                            Route Details 
                                                        </h4> 
                                                        <p class="text-xs text-neutral-300 leading-relaxed bg-neutral-900/60 p-3.5 rounded-xl border border-neutral-800"> 
                                                            {{ $taxi->description }} 
                                                        </p> 
                                                    </div> 
                                                @endif 

                                                <div> 
                                                    <h4 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 font-mono-code mb-2"> 
                                                        What's Included 
                                                    </h4> 
                                                    <div class="grid grid-cols-2 gap-2 text-xs font-mono-code text-zinc-300"> 
                                                        <div class="flex items-center gap-2 p-2 rounded-xl bg-neutral-900/50 border border-neutral-800"> 
                                                            <span>⛽</span> <span>Fuel Included</span> 
                                                        </div> 
                                                        <div class="flex items-center gap-2 p-2 rounded-xl bg-neutral-900/50 border border-neutral-800"> 
                                                            <span>👨‍✈️</span> <span>Professional Driver</span> 
                                                        </div> 
                                                        <div class="flex items-center gap-2 p-2 rounded-xl bg-neutral-900/50 border border-neutral-800"> 
                                                            <span>🛡️</span> <span>Passenger Insurance</span> 
                                                        </div> 
                                                        <div class="flex items-center gap-2 p-2 rounded-xl bg-neutral-900/50 border border-neutral-800"> 
                                                            <span>📍</span> <span>Door-to-Door Service</span> 
                                                        </div> 
                                                    </div> 
                                                </div> 

                                                <div> 
                                                    <h4 class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 font-mono-code mb-2"> 
                                                        Amenities 
                                                    </h4> 
                                                    <div class="flex flex-wrap gap-1.5 text-xs font-mono-code"> 
                                                        <span class="px-2.5 py-1 rounded-lg bg-neutral-900 border border-neutral-800 text-zinc-300">❄️ Air Conditioning</span> 
                                                        <span class="px-2.5 py-1 rounded-lg bg-neutral-900 border border-neutral-800 text-zinc-300">📶 Free Wi-Fi</span> 
                                                        <span class="px-2.5 py-1 rounded-lg bg-neutral-900 border border-neutral-800 text-zinc-300">🔌 USB Charging</span> 
                                                        <span class="px-2.5 py-1 rounded-lg bg-neutral-900 border border-neutral-800 text-zinc-300">💧 Drinking Water</span> 
                                                        @if(!empty($taxi->seats)) 
                                                            <span class="px-2.5 py-1 rounded-lg bg-neutral-900 border border-neutral-800 text-emerald-400 font-bold">💺 {{ $taxi->seats }} Seats</span> 
                                                        @endif 
                                                    </div> 
                                                </div> 

                                                <div class="text-[10px] font-mono-code text-zinc-500 space-y-0.5"> 
                                                    <p>• Cancellation Policy: {{ $taxi->cancellation_policy ?: 'Please notify us at least 24 hours in advance.' }}</p> 
                                                    <p>• Luggage: {{ $taxi->luggage ?: 'Standard luggage: 6-8 bags.' }}</p> 
                                                </div> 
                                            </div> 

                                            {{-- BOOKING CALCULATOR BOX --}} 
                                            <div class="lg:col-span-6 bg-black p-5 sm:p-6 rounded-2xl border border-emerald-500/20 shadow-lg space-y-4"> 
                                                <div class="border-b border-neutral-800 pb-2.5"> 
                                                    <h4 class="text-xs font-black uppercase text-white tracking-wider flex items-center gap-2"> 
                                                        <span>🗓️</span> Select Travel Date &amp; Calculate Price 
                                                    </h4> 
                                                </div> 

                                                @if($perPersonPrice > 0) 
                                                    <div class="space-y-1"> 
                                                        <label class="block text-[10px] font-mono-code uppercase font-bold text-zinc-400">Booking Type</label> 
                                                        <div class="grid grid-cols-2 gap-2"> 
                                                            <button type="button" @click="bookingType = 'charter'"  
                                                                    :class="bookingType === 'charter' ? 'bg-emerald-500 text-black font-black border-emerald-500' : 'bg-neutral-900 text-zinc-400 border-neutral-800 hover:text-white'" 
                                                                    class="py-2 px-2.5 rounded-xl border text-[11px] font-mono-code transition text-center"> 
                                                                Private Charter (฿{{ number_format($charterPrice) }}) 
                                                            </button> 
                                                            <button type="button" @click="bookingType = 'per_person'"  
                                                                    :class="bookingType === 'per_person' ? 'bg-teal-400 text-black font-black border-teal-400' : 'bg-neutral-900 text-zinc-400 border-neutral-800 hover:text-white'" 
                                                                    class="py-2 px-2.5 rounded-xl border text-[11px] font-mono-code transition text-center"> 
                                                                Shared (฿{{ number_format($perPersonPrice) }}/person) 
                                                            </button> 
                                                        </div> 
                                                    </div> 
                                                @endif 

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3"> 
                                                    <div> 
                                                        <label class="block text-[10px] font-mono-code uppercase font-bold text-zinc-400 mb-1">Travel Date</label> 
                                                        <input type="date" x-model="travelDate" class="w-full bg-neutral-900 text-white font-mono-code text-xs p-2.5 rounded-xl border border-neutral-800 focus:border-emerald-500 focus:outline-none"> 
                                                    </div> 
                                                    <div> 
                                                        <label class="block text-[10px] font-mono-code uppercase font-bold text-zinc-400 mb-1">Pickup Time</label> 
                                                        <input type="text" x-model="pickupTime" placeholder="08:30" class="w-full bg-neutral-900 text-white font-mono-code text-xs p-2.5 rounded-xl border border-neutral-800 focus:border-emerald-500 focus:outline-none"> 
                                                    </div> 
                                                </div> 

                                                <div> 
                                                    <div class="flex items-center justify-between mb-1"> 
                                                        <label class="text-[10px] font-mono-code uppercase font-bold text-zinc-400">Passengers</label> 
                                                        <span class="text-xs font-mono-code font-bold text-emerald-400" x-text="paxCount + ' passengers'"></span> 
                                                    </div> 
                                                    <div class="flex items-center gap-2.5"> 
                                                        <button type="button" @click="if(paxCount > 1) paxCount--" class="w-9 h-9 rounded-xl bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 text-white font-bold text-sm transition flex items-center justify-center">-</button> 
                                                        <input type="range" min="1" max="{{ $taxi->seats ?: 11 }}" x-model="paxCount" class="flex-grow accent-emerald-500 bg-neutral-800 h-2 rounded-lg cursor-pointer"> 
                                                        <button type="button" @click="if(paxCount < {{ $taxi->seats ?: 11 }}) paxCount++" class="w-9 h-9 rounded-xl bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 text-white font-bold text-sm transition flex items-center justify-center">+</button> 
                                                    </div> 
                                                </div> 

                                                <div class="pt-3 border-t border-neutral-800 space-y-2.5"> 
                                                    <div class="flex items-center justify-between"> 
                                                        <span class="text-xs font-mono-code text-zinc-400">Total:</span> 
                                                        <div class="text-right"> 
                                                            <span class="text-xl font-black font-mono-code text-emerald-400" x-text="'฿' + calculateTotal().toLocaleString()"></span> 
                                                        </div> 
                                                    </div> 

                                                    <button type="button" @click="sendBookingToChat()" class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black text-xs font-mono-code uppercase tracking-wider shadow-md transition flex items-center justify-center gap-2"> 
                                                        <span>💬 Confirm Booking via Live Chat</span> 
                                                        <span>➔</span> 
                                                    </button> 
                                                </div> 
                                            </div> 

                                        </div> 

                                    </div> 

                                </div> 
                            @endforeach 
                        </div> 
                    @else 
                        <div class="py-8 text-center rounded-2xl border border-dashed border-neutral-800"> 
                            <p class="text-xs text-neutral-500 font-mono-code">No taxi routes available in the {{ $zone['name'] }} Zone.</p> 
                        </div> 
                    @endif 

                </div> 
            </div> 
        </div> 
    @endforeach 
</div> 

{{-- ========================================================= --}} 
{{-- BOTTOM CUSTOM TRIP SUPPORT --}} 
{{-- ========================================================= --}} 
<div class="mt-14 rounded-3xl border border-emerald-500/20 bg-emerald-950/20 p-7 sm:p-9 text-center space-y-4"> 
    <div class="text-3xl">🗺️</div> 
    <div class="space-y-1"> 
        <h2 class="text-xl font-black text-white">Need a Custom Cross-Province Trip?</h2> 
        <p class="text-xs text-neutral-400 max-w-xl mx-auto"> 
            Can't find the route you're looking for? Need a VIP van with a private driver for a full-day or cross-province trip? Chat with our admin team for a special quotation, available 24/7. 
        </p> 
    </div> 
    <button type="button" 
            @click="$dispatch('open-rango-chat', { message: 'Hello, I would like to inquire about a Custom Trip private transfer service.' })" 
            class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-neutral-950 rounded-xl text-xs font-black uppercase tracking-wider font-mono-code transition shadow-lg shadow-emerald-500/20 inline-flex items-center gap-2"> 
        <span>💬 Ask About Custom Routes</span> <span>→</span> 
    </button> 
</div> 
```

</div> 
@endsection
