@extends('layouts.admin')

@section('title', 'EDIT TAXI ROUTE // RANGO ADMIN')
@section('header', 'EDIT TAXI ROUTE')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- BACK LINK --}}
    <a href="{{ route('admin.taxis.index') }}"
       class="inline-flex items-center gap-2 text-xs font-mono-code text-emerald-400 hover:text-emerald-300 transition">
        &larr; Back to Transfers
    </a>

    {{-- PAGE HEADER --}}
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-xl">
                ✏️
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">
                    Edit Transfer Route
                </h2>
                <p class="text-xs text-zinc-500 mt-1 font-mono-code">
                    {{ $taxi->route_name ?: (($taxi->from_location ?? '') . ' ➔ ' . ($taxi->to_location ?? '')) }}
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.taxis.update', $taxi->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf
        @method('PUT')

        @php
            // แปลงข้อมูล features และ included จาก JSON/Array เพื่อให้เช็คค่า checkbox เดิมได้ถูกต้อง
            $activeFeatures = old('features', is_array($taxi->features) ? $taxi->features : (json_decode($taxi->features ?? '[]', true) ?? ['air_conditioner', 'wifi', 'usb', 'water']));
            $activeInclusions = old('included', is_array($taxi->included) ? $taxi->included : (json_decode($taxi->included ?? '[]', true) ?? ['fuel', 'driver', 'insurance', 'toll', 'pickup', 'water']));
        @endphp

        {{-- ========================================================= --}}
        {{-- 01 ROUTE BASIC INFORMATION --}}
        {{-- ========================================================= --}}
        <div class="glass-panel rounded-3xl border border-emerald-500/15 overflow-hidden">
            <div class="px-6 py-5 border-b border-zinc-800 bg-emerald-500/[0.03]">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 font-mono-code font-bold flex items-center justify-center text-xs">
                        01
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">
                            Basic Route Information
                        </h3>
                        <p class="text-[10px] text-zinc-500 mt-0.5 font-mono-code">
                            Select destination zone and route endpoints
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- ZONE --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Destination Zone <span class="text-rose-400">*</span>
                    </label>
                    <select name="zone"
                            required
                            class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                        <option value="phuket" {{ old('zone', $taxi->zone) == 'phuket' ? 'selected' : '' }}>🏝️ Phuket Zone</option>
                        <option value="khaosok" {{ old('zone', $taxi->zone) == 'khaosok' ? 'selected' : '' }}>🛶 Khao Sok &amp; Cheow Lan Lake Zone</option>
                        <option value="phangnga" {{ old('zone', $taxi->zone) == 'phangnga' ? 'selected' : '' }}>⛰️ Phang Nga &amp; Khao Lak Zone</option>
                        <option value="krabi" {{ old('zone', $taxi->zone) == 'krabi' ? 'selected' : '' }}>🏖️ Krabi &amp; Ao Nang Zone</option>
                    </select>
                </div>

                {{-- VEHICLE TYPE --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Vehicle Type <span class="text-rose-400">*</span>
                    </label>
                    <input type="text"
                           name="vehicle_type"
                           value="{{ old('vehicle_type', $taxi->vehicle_type) }}"
                           required
                           placeholder="e.g. VIP Minivan, Luxury SUV, Sedan"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- ROUTE NAME --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-emerald-400 mb-2 uppercase font-mono-code">
                        Route Display Name <span class="text-rose-400">*</span>
                    </label>
                    <input type="text"
                           name="route_name"
                           value="{{ old('route_name', $taxi->route_name) }}"
                           required
                           placeholder="e.g. Phuket Airport ➔ Khao Sok National Park"
                           class="w-full bg-black/80 text-white border border-emerald-500/30 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- FROM LOCATION --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Pickup Location (From)
                    </label>
                    <input type="text"
                           name="from_location"
                           value="{{ old('from_location', $taxi->from_location) }}"
                           placeholder="e.g. Phuket International Airport (HKT)"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- TO LOCATION --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Drop-off Location (To)
                    </label>
                    <input type="text"
                           name="to_location"
                           value="{{ old('to_location', $taxi->to_location) }}"
                           placeholder="e.g. Cheow Lan Lake Pier / Resort"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 02 PRICING & RATES (CHARTER & PER PERSON) --}}
        {{-- ========================================================= --}}
        <div class="glass-panel rounded-3xl border border-emerald-500/15 overflow-hidden">
            <div class="px-6 py-5 border-b border-zinc-800 bg-emerald-500/[0.03]">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 font-mono-code font-bold flex items-center justify-center text-xs">
                        02
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">
                            Pricing &amp; Fares
                        </h3>
                        <p class="text-[10px] text-zinc-500 mt-0.5 font-mono-code">
                            Set private vehicle charter rate and per-person shared price
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- PRIVATE CHARTER PRICE --}}
                <div>
                    <label class="block text-xs font-bold text-emerald-400 mb-2 uppercase font-mono-code">
                        Private Charter (Per Vehicle) <span class="text-rose-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 font-bold font-mono-code">
                            ฿
                        </span>
                        <input type="number"
                               name="price"
                               value="{{ old('price', $taxi->price) }}"
                               step="0.01"
                               min="0"
                               required
                               placeholder="2800"
                               class="w-full bg-black/80 text-emerald-400 font-bold font-mono-code border border-zinc-800 rounded-2xl py-4 pl-9 pr-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                    </div>
                    <span class="text-[10px] text-zinc-500 font-mono-code mt-1 block">Full vehicle flat rate</span>
                </div>

                {{-- PRICE PER PERSON --}}
                <div>
                    <label class="block text-xs font-bold text-teal-300 mb-2 uppercase font-mono-code">
                        Price Per Person (Optional)
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-teal-400 font-bold font-mono-code">
                            ฿
                        </span>
                        <input type="number"
                               name="price_per_person"
                               value="{{ old('price_per_person', $taxi->price_per_person) }}"
                               step="0.01"
                               min="0"
                               placeholder="e.g. 650"
                               class="w-full bg-black/80 text-teal-300 font-bold font-mono-code border border-zinc-800 rounded-2xl py-4 pl-9 pr-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                    </div>
                    <span class="text-[10px] text-zinc-500 font-mono-code mt-1 block">Shared seat rate / person</span>
                </div>

                {{-- EXTRA SURCHARGE --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Extra Surcharge
                    </label>
                    <input type="number"
                           name="extra_fee"
                           value="{{ old('extra_fee', $taxi->extra_fee ?? 0) }}"
                           step="0.01"
                           min="0"
                           placeholder="0"
                           class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                    <span class="text-[10px] text-zinc-500 font-mono-code mt-1 block">Night fee / Peak season</span>
                </div>

                {{-- CURRENCY --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Currency
                    </label>
                    <select name="currency"
                            class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                        <option value="THB" {{ old('currency', $taxi->currency ?? 'THB') == 'THB' ? 'selected' : '' }}>THB (฿)</option>
                        <option value="USD" {{ old('currency', $taxi->currency ?? 'THB') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ old('currency', $taxi->currency ?? 'THB') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                    </select>
                </div>

                {{-- PRICE NOTE --}}
                <div class="sm:col-span-2 lg:col-span-4">
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Pricing Notes
                    </label>
                    <textarea name="price_note"
                              rows="2"
                              placeholder="e.g. Rates include gasoline, driver, highway expressway fees, and travel insurance."
                              class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">{{ old('price_note', $taxi->price_note) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 03 ESTIMATED TIME & SCHEDULE --}}
        {{-- ========================================================= --}}
        <div class="glass-panel rounded-3xl border border-emerald-500/15 overflow-hidden">
            <div class="px-6 py-5 border-b border-zinc-800 bg-emerald-500/[0.03]">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 font-mono-code font-bold flex items-center justify-center text-xs">
                        03
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">
                            Duration &amp; Timetable
                        </h3>
                        <p class="text-[10px] text-zinc-500 mt-0.5 font-mono-code">
                            Travel time, departure intervals, and booking notice
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- DURATION --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Estimated Travel Time
                    </label>
                    <input type="text"
                           name="duration"
                           value="{{ old('duration', $taxi->duration) }}"
                           placeholder="e.g. 2 - 2.5 Hours"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- DISTANCE --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Distance (Approx.)
                    </label>
                    <input type="text"
                           name="distance"
                           value="{{ old('distance', $taxi->distance) }}"
                           placeholder="e.g. 145 km"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- PICKUP TIMES --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-emerald-400 mb-2 uppercase font-mono-code">
                        Departure Schedules / Pickup Hours
                    </label>
                    <input type="text"
                           name="pickup_times"
                           value="{{ old('pickup_times', $taxi->pickup_times) }}"
                           placeholder="e.g. 08:30, 11:30, 15:00 or On-demand 24/7"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- PICKUP FLEXIBILITY --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Schedule Flexibility
                    </label>
                    <select name="pickup_flexible"
                            class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                        <option value="flexible" {{ old('pickup_flexible', $taxi->pickup_flexible ?? '') == 'flexible' ? 'selected' : '' }}>Flexible Departure (Custom Time)</option>
                        <option value="fixed" {{ old('pickup_flexible', $taxi->pickup_flexible ?? '') == 'fixed' ? 'selected' : '' }}>Fixed Timetable</option>
                        <option value="24h" {{ old('pickup_flexible', $taxi->pickup_flexible ?? '') == '24h' ? 'selected' : '' }}>24/7 Available</option>
                    </select>
                </div>

                {{-- ADVANCE BOOKING --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Minimum Advance Notice
                    </label>
                    <input type="text"
                           name="advance_booking"
                           value="{{ old('advance_booking', $taxi->advance_booking) }}"
                           placeholder="e.g. At least 2 hours prior"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 04 VEHICLE SPECS & AMENITIES --}}
        {{-- ========================================================= --}}
        <div class="glass-panel rounded-3xl border border-emerald-500/15 overflow-hidden">
            <div class="px-6 py-5 border-b border-zinc-800 bg-emerald-500/[0.03]">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 font-mono-code font-bold flex items-center justify-center text-xs">
                        04
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">
                            Vehicle Specifications
                        </h3>
                        <p class="text-[10px] text-zinc-500 mt-0.5 font-mono-code">
                            Passenger capacity, luggage room, and onboard features
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- SEATS --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Passenger Seats
                    </label>
                    <input type="number"
                           name="seats"
                           value="{{ old('seats', $taxi->seats ?? 10) }}"
                           min="1"
                           placeholder="10"
                           class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- LUGGAGE --}}
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Luggage Capacity
                    </label>
                    <input type="text"
                           name="luggage"
                           value="{{ old('luggage', $taxi->luggage) }}"
                           placeholder="e.g. 6-8 Standard Suitcases"
                           class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">
                </div>

                {{-- VEHICLE FEATURES --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-zinc-300 mb-3 uppercase font-mono-code">
                        Onboard Amenities
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <label class="flex items-center gap-2 bg-black/30 border border-zinc-800 hover:border-emerald-500/30 rounded-xl p-3 cursor-pointer transition">
                            <input type="checkbox" name="features[]" value="air_conditioner" {{ in_array('air_conditioner', (array) $activeFeatures) ? 'checked' : '' }} class="rounded bg-black border-zinc-700 text-emerald-500">
                            <span class="text-xs text-zinc-300">❄️ Air Conditioning</span>
                        </label>
                        <label class="flex items-center gap-2 bg-black/30 border border-zinc-800 hover:border-emerald-500/30 rounded-xl p-3 cursor-pointer transition">
                            <input type="checkbox" name="features[]" value="wifi" {{ in_array('wifi', (array) $activeFeatures) ? 'checked' : '' }} class="rounded bg-black border-zinc-700 text-emerald-500">
                            <span class="text-xs text-zinc-300">📶 Free Wi-Fi</span>
                        </label>
                        <label class="flex items-center gap-2 bg-black/30 border border-zinc-800 hover:border-emerald-500/30 rounded-xl p-3 cursor-pointer transition">
                            <input type="checkbox" name="features[]" value="usb" {{ in_array('usb', (array) $activeFeatures) ? 'checked' : '' }} class="rounded bg-black border-zinc-700 text-emerald-500">
                            <span class="text-xs text-zinc-300">🔌 USB Charging</span>
                        </label>
                        <label class="flex items-center gap-2 bg-black/30 border border-zinc-800 hover:border-emerald-500/30 rounded-xl p-3 cursor-pointer transition">
                            <input type="checkbox" name="features[]" value="water" {{ in_array('water', (array) $activeFeatures) ? 'checked' : '' }} class="rounded bg-black border-zinc-700 text-emerald-500">
                            <span class="text-xs text-zinc-300">💧 Bottled Water</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 05 WHAT'S INCLUDED & DESCRIPTION --}}
        {{-- ========================================================= --}}
        <div class="glass-panel rounded-3xl border border-emerald-500/15 overflow-hidden">
            <div class="px-6 py-5 border-b border-zinc-800 bg-emerald-500/[0.03]">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 font-mono-code font-bold flex items-center justify-center text-xs">
                        05
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">
                            Service Inclusions &amp; Overview
                        </h3>
                        <p class="text-[10px] text-zinc-500 mt-0.5 font-mono-code">
                            Specify package inclusions and route highlights
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach([
                        ['fuel', '⛽', 'Fuel & Gas'],
                        ['driver', '👨‍✈️', 'Licensed Driver'],
                        ['insurance', '🛡️', 'Travel Insurance'],
                        ['toll', '🛣️', 'Expressway Tolls'],
                        ['pickup', '📍', 'Door-to-Door Pickup'],
                        ['water', '💧', 'Drinking Water'],
                    ] as $item)
                        <label class="flex items-center gap-3 bg-black/30 border border-zinc-800 hover:border-emerald-500/30 rounded-xl p-4 cursor-pointer transition">
                            <input type="checkbox"
                                   name="included[]"
                                   value="{{ $item[0] }}"
                                   {{ in_array($item[0], (array) $activeInclusions) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded bg-black border-zinc-700 text-emerald-500">
                            <span class="text-base">{{ $item[1] }}</span>
                            <span class="text-xs font-bold text-zinc-300">{{ $item[2] }}</span>
                        </label>
                    @endforeach
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Route Description &amp; Details
                    </label>
                    <textarea name="description"
                              rows="4"
                              placeholder="e.g. VIP private transfer service connecting Phuket International Airport directly to Cheow Lan Lake Pier and surrounding resorts."
                              class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">{{ old('description', $taxi->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 06 TERMS & CANCELLATION --}}
        {{-- ========================================================= --}}
        <div class="glass-panel rounded-3xl border border-emerald-500/15 overflow-hidden">
            <div class="px-6 py-5 border-b border-zinc-800 bg-emerald-500/[0.03]">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 font-mono-code font-bold flex items-center justify-center text-xs">
                        06
                    </span>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">
                            Policies &amp; Conditions
                        </h3>
                        <p class="text-[10px] text-zinc-500 mt-0.5 font-mono-code">
                            Cancellation terms and pickup requirements
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Cancellation Policy
                    </label>
                    <textarea name="cancellation_policy"
                              rows="3"
                              placeholder="e.g. Free cancellation up to 24 hours prior to scheduled departure."
                              class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">{{ old('cancellation_policy', $taxi->cancellation_policy) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-300 mb-2 uppercase font-mono-code">
                        Terms &amp; Luggage Conditions
                    </label>
                    <textarea name="terms"
                              rows="3"
                              placeholder="e.g. Oversized sports equipment or pet transport must be notified in advance."
                              class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs focus:border-emerald-500 focus:outline-none transition">{{ old('terms', $taxi->terms) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- 07 STATUS & VISIBILITY --}}
        {{-- ========================================================= --}}
        <div class="glass-panel rounded-3xl border border-emerald-500/15">
            <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                <div>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">
                        Publish Status
                    </h3>
                    <p class="text-xs text-zinc-500 mt-1 font-mono-code">
                        Make this transfer route live and bookable on the front website
                    </p>
                </div>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox"
                           name="status"
                           value="1"
                           {{ old('status', $taxi->status) ? 'checked' : '' }}
                           class="w-5 h-5 rounded bg-black border-zinc-700 text-emerald-500 focus:ring-0">
                    <span class="text-xs font-bold text-white uppercase font-mono-code">
                        Active &amp; Published
                    </span>
                </label>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- SUBMIT ACTIONS --}}
        {{-- ========================================================= --}}
        <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-2">
            <a href="{{ route('admin.taxis.index') }}"
               class="px-6 py-3.5 bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-400 hover:text-white font-bold text-xs uppercase rounded-xl text-center transition">
                Cancel
            </a>

            <button type="submit"
                    class="px-8 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-black font-black uppercase text-xs tracking-wider rounded-xl shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-2">
                <span>💾</span> Update Transfer Route
            </button>
        </div>

    </form>
</div>
@endsection