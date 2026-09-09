@extends('layouts.admin')

@section('title', 'COMMAND MATRIX // RANGO TOUR ADMIN')
@section('header', 'SYSTEM COMMAND MATRIX')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6 sm:space-y-10" x-data="dashboardMatrix()">

    <!-- =========================================================================
         1. TOP COMMAND BAR
         ========================================================================= -->
    <div class="glass-panel p-5 sm:p-7 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 shadow-2xl relative overflow-hidden flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="absolute -right-20 -top-20 w-60 sm:w-80 h-60 sm:h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex items-center gap-4 sm:gap-5 z-10">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-950 p-0.5 shadow-xl shadow-emerald-500/30 flex items-center justify-center shrink-0">
                <div class="w-full h-full bg-[#080a0c] rounded-[14px] flex items-center justify-center relative overflow-hidden">
                    <span class="text-emerald-400 text-xl sm:text-2xl animate-pulse">⚡</span>
                </div>
            </div>

            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-lg sm:text-2xl font-black text-white tracking-tight">RANGO MASTER CONTROL</h2>
                    <span class="px-2 py-0.5 rounded-full text-[9px] sm:text-[10px] font-mono-code font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                        SURAT THANI
                    </span>
                </div>
                <p class="text-[11px] sm:text-xs font-mono-code text-zinc-400 mt-0.5 flex flex-wrap items-center gap-1.5 sm:gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>TIME: <strong class="text-emerald-400" x-text="currentTime"></strong></span>
                    <span class="hidden sm:inline text-zinc-600">•</span>
                    <span class="hidden sm:inline">SERVER: 0.12ms</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2.5 z-10">
            <button @click="openQuickTourModal = true" class="col-span-2 sm:col-span-1 px-4 sm:px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-400 text-neutral-950 font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/25 active:scale-95 transition flex items-center justify-center gap-2">
                <span>+</span> Quick Add Tour
            </button>

            <form action="{{ route('admin.flushCache') }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-2xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 border border-zinc-800 text-xs font-mono-code font-bold transition flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Flush Cache</span>
                </button>
            </form>

            <a href="{{ route('home') }}" target="_blank" class="px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-2xl bg-zinc-900 hover:bg-zinc-800 text-emerald-400 border border-emerald-500/30 text-xs font-bold uppercase tracking-wider transition flex items-center justify-center gap-1">
                <span>Live Front</span> ↗
            </a>
        </div>
    </div>


    <!-- =========================================================================
         2. 4 REAL KPI CARDS
         ========================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Card 1: Total Tours -->
        <div class="glass-panel p-5 sm:p-6 rounded-3xl border border-emerald-500/15 relative overflow-hidden group hover:border-emerald-500/40 transition">
            <div class="flex items-center justify-between text-zinc-400 mb-2">
                <span class="text-[10px] font-mono-code font-bold uppercase tracking-widest text-emerald-400">// PACKAGES</span>
                <span class="px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-400 text-[10px] font-mono-code">ACTIVE</span>
            </div>
            <div class="flex items-baseline justify-between">
                <div>
                    <span class="text-3xl sm:text-5xl font-black text-white font-mono-code">{{ $totalTours }}</span>
                    <span class="text-xs text-zinc-500 ml-1 font-mono-code">Total</span>
                </div>
                <div class="text-2xl sm:text-3xl text-emerald-400">🧭</div>
            </div>
            <div class="mt-3 pt-3 border-t border-zinc-800/80 flex items-center justify-between text-[11px] font-mono-code">
                <span class="text-emerald-400 font-bold">● {{ $activeTours }} On Sale</span>
                <a href="{{ route('admin.tours.index') }}" class="text-zinc-400 hover:text-white">Manage &rarr;</a>
            </div>
        </div>

        <!-- Card 2: Inquiries (Real Chat count) -->
        <div class="glass-panel p-5 sm:p-6 rounded-3xl border border-emerald-500/15 relative overflow-hidden group hover:border-teal-500/40 transition">
            <div class="flex items-center justify-between text-zinc-400 mb-2">
                <span class="text-[10px] font-mono-code font-bold uppercase tracking-widest text-teal-400">// INQUIRIES</span>
                <span class="px-2 py-0.5 rounded-md bg-teal-500/10 text-teal-300 text-[10px] font-mono-code font-bold">{{ $lastWeekInquiries }} This Week</span>
            </div>
            <div class="flex items-baseline justify-between">
                <div>
                    <span class="text-3xl sm:text-5xl font-black text-white font-mono-code">{{ $totalInquiries }}</span>
                    <span class="text-xs text-zinc-500 ml-1 font-mono-code">Chats</span>
                </div>
                <div class="text-2xl sm:text-3xl text-teal-400">💬</div>
            </div>
            <div class="mt-3 pt-3 border-t border-zinc-800/80 flex items-center justify-between text-[11px] font-mono-code">
                <span class="text-zinc-400">Web &amp; Line Support</span>
                <a href="{{ route('admin.chats.index') }}" class="text-emerald-400 hover:text-emerald-300 font-bold">Inbox &rarr;</a>
            </div>
        </div>

        <!-- Card 3: Satisfaction (Real Reviews rating) -->
        <div class="glass-panel p-5 sm:p-6 rounded-3xl border border-emerald-500/15 relative overflow-hidden group hover:border-amber-500/40 transition">
            <div class="flex items-center justify-between text-zinc-400 mb-2">
                <span class="text-[10px] font-mono-code font-bold uppercase tracking-widest text-amber-400">// RATING</span>
                <span class="px-2 py-0.5 rounded-md bg-amber-500/10 text-amber-300 text-[10px] font-mono-code font-bold">{{ $fiveStarPercent }}% 5★</span>
            </div>
            <div class="flex items-baseline justify-between">
                <div>
                    <span class="text-3xl sm:text-5xl font-black text-white font-mono-code">{{ $avgRating }}</span>
                    <span class="text-xs text-amber-400 ml-1 font-bold">/ 5.0 ★</span>
                </div>
                <div class="text-2xl sm:text-3xl text-amber-400">⭐</div>
            </div>
            <div class="mt-3 pt-3 border-t border-zinc-800/80 flex items-center justify-between text-[11px] font-mono-code">
                <span class="text-zinc-400">{{ $totalReviews }} Reviews</span>
                <a href="{{ route('admin.reviews.index') }}" class="text-amber-400 hover:underline">Moderate &rarr;</a>
            </div>
        </div>

        <!-- Card 4: Lake Capacity (Real Available Seats & Resorts count) -->
        <div class="glass-panel p-5 sm:p-6 rounded-3xl border border-emerald-500/15 relative overflow-hidden group hover:border-emerald-400/40 transition">
            <div class="flex items-center justify-between text-zinc-400 mb-2">
                <span class="text-[10px] font-mono-code font-bold uppercase tracking-widest text-emerald-400">// LAKE SEATS</span>
                <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 text-[10px] font-mono-code font-bold">LIVE</span>
            </div>
            <div class="flex items-baseline justify-between">
                <div>
                    <span class="text-3xl sm:text-5xl font-black text-white font-mono-code">{{ $totalSeatsAvailable }}</span>
                    <span class="text-xs text-zinc-500 ml-1 font-mono-code">Seats</span>
                </div>
                <div class="text-2xl sm:text-3xl text-emerald-400">🏝️</div>
            </div>
            <div class="mt-3 pt-3 border-t border-zinc-800/80 flex items-center justify-between text-[11px] font-mono-code">
                <span class="text-emerald-400">{{ $totalResorts }} Resorts Matrix</span>
                <span class="text-zinc-400">Cheow Lan</span>
            </div>
        </div>
    </div>


    <!-- =========================================================================
         3. CHARTS ZONE (Real Dynamics from Database)
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-stretch">
        <!-- Main Line Chart (8 Cols) -->
        <div class="lg:col-span-8 glass-panel p-5 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 shadow-2xl flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 sm:mb-6">
                <div>
                    <span class="text-[10px] font-mono-code text-emerald-400 uppercase tracking-widest font-bold">// INQUIRY VELOCITY</span>
                    <h3 class="text-base sm:text-lg font-black text-white tracking-tight">Booking Inquiries Trend</h3>
                </div>

                <div class="flex items-center gap-1 bg-black/60 p-1 rounded-2xl border border-zinc-800 text-xs font-mono-code self-start sm:self-auto">
                    <button @click="chartRange = '7D'; updateChart()" :class="chartRange === '7D' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400'" class="px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-xl transition">7D</button>
                    <button @click="chartRange = '30D'; updateChart()" :class="chartRange === '30D' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400'" class="px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-xl transition">30D</button>
                    <button @click="chartRange = '1Y'; updateChart()" :class="chartRange === '1Y' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400'" class="px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-xl transition">Year</button>
                </div>
            </div>

            <!-- Responsive Canvas Height -->
            <div class="relative w-full h-[220px] sm:h-[300px]">
                <canvas id="inquiryChart"></canvas>
            </div>

            <div class="pt-3 sm:pt-4 mt-3 sm:mt-4 border-t border-zinc-800/80 flex flex-wrap items-center justify-between text-[10px] sm:text-xs font-mono-code text-zinc-400 gap-2">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Live Inquiries Logged</span>
                <span class="text-emerald-400 font-bold">AVG RESPONSE: &lt; 4 MINS</span>
            </div>
        </div>

        <!-- Donut Split (4 Cols) -->
        <div class="lg:col-span-4 glass-panel p-5 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 shadow-2xl flex flex-col justify-between space-y-4 sm:space-y-6">
            <div>
                <span class="text-[10px] font-mono-code text-teal-400 uppercase tracking-widest font-bold">// CHANNELS</span>
                <h3 class="text-base sm:text-lg font-black text-white tracking-tight">Contact Channel Ratio</h3>
            </div>

            <div class="relative w-full h-36 sm:h-44 flex items-center justify-center">
                <canvas id="channelDonut"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-xl sm:text-2xl font-black text-white">{{ max($totalInquiries, 1) }}</span>
                    <span class="text-[9px] sm:text-[10px] font-mono-code text-emerald-400 uppercase">INQUIRIES</span>
                </div>
            </div>

            <div class="space-y-2.5">
                <div>
                    <div class="flex justify-between text-[11px] font-mono-code mb-1">
                        <span class="text-zinc-300">Live Webchat</span>
                        <span class="font-bold text-emerald-400">{{ $totalInquiries }}</span>
                    </div>
                    <div class="w-full bg-zinc-950 h-2 rounded-full overflow-hidden border border-zinc-800">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-mono-code mb-1">
                        <span class="text-zinc-300">LINE Official</span>
                        <span class="font-bold text-teal-400">Direct OA</span>
                    </div>
                    <div class="w-full bg-zinc-950 h-2 rounded-full overflow-hidden border border-zinc-800">
                        <div class="bg-[#06C755] h-full rounded-full" style="width: 80%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- =========================================================================
         4. REAL RESORTS GRID (ดึงจากตาราง resorts จริง)
         ========================================================================= -->
    <div class="glass-panel p-5 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 shadow-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4 sm:mb-6 pb-3 border-b border-zinc-800">
            <div>
                <span class="text-[10px] font-mono-code text-emerald-400 uppercase tracking-widest font-bold">// NETWORK</span>
                <h3 class="text-base sm:text-lg font-black text-white uppercase tracking-tight">
                    Cheow Lan Lake Floating Bungalows &amp; Resorts
                </h3>
            </div>
            <a href="{{ route('admin.resorts.index') }}" class="text-xs font-mono-code text-emerald-400 hover:underline font-bold">
                Manage Resorts &rarr;
            </a>
        </div>

        @if($resorts->isEmpty())
            <div class="text-center py-8 border border-dashed border-zinc-800 rounded-2xl">
                <p class="text-xs font-mono-code text-zinc-500">No lake resorts added yet.</p>
                <a href="{{ route('admin.resorts.create') }}" class="text-xs font-bold text-emerald-400 hover:underline mt-1 inline-block">+ Add First Resort</a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2.5 sm:gap-3">
                @foreach($resorts as $resort)
                    <div class="bg-black/60 p-3 rounded-2xl border border-zinc-800 text-center group">
                        <div class="w-10 h-10 mx-auto rounded-xl overflow-hidden mb-1.5 border border-zinc-700 bg-neutral-950">
                            <img src="{{ asset('storage/' . $resort->image) }}" alt="{{ $resort->name }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                        </div>
                        <h5 class="text-[10px] sm:text-[11px] font-bold text-white truncate">{{ $resort->name }}</h5>
                        <span class="mt-1 inline-block px-1.5 py-0.5 rounded text-[8px] sm:text-[9px] font-mono-code font-bold text-emerald-400 bg-emerald-950/60 border border-emerald-800/80">
                            {{ $resort->subtitle ?? 'Resort' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


    <!-- =========================================================================
         5. REAL TOURS INVENTORY TABLE
         ========================================================================= -->
    <div class="glass-panel p-5 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 shadow-2xl space-y-4 sm:space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-[10px] font-mono-code text-emerald-400 uppercase tracking-widest font-bold">// INVENTORY</span>
                <h3 class="text-lg sm:text-xl font-black text-white uppercase tracking-tight">
                    Active Tour Packages
                </h3>
            </div>

            <!-- Search Field -->
            <div class="w-full sm:w-auto">
                <input type="text" x-model="searchQuery" placeholder="Search tour or location..." 
                       class="w-full sm:w-64 bg-black/70 text-white placeholder-zinc-500 border border-zinc-800 focus:border-emerald-500 rounded-xl px-4 py-2.5 text-xs font-mono-code focus:outline-none">
            </div>
        </div>

        @if($allTours->isEmpty())
            <div class="text-center py-12 border border-dashed border-zinc-800 rounded-3xl">
                <span class="text-3xl block mb-1">🧭</span>
                <p class="text-xs text-zinc-500">No tours added yet.</p>
                <a href="{{ route('admin.tours.create') }}" class="text-xs font-bold text-emerald-400 hover:underline mt-1 inline-block">+ Create Tour Package</a>
            </div>
        @else
            <div class="overflow-x-auto -mx-5 sm:mx-0 px-5 sm:px-0">
                <table class="w-full text-left text-xs text-zinc-300 min-w-[600px]">
                    <thead class="bg-black/60 uppercase font-mono-code text-[10px] text-zinc-400 font-bold border-b border-zinc-800">
                        <tr>
                            <th class="p-3.5 rounded-l-2xl">Cover</th>
                            <th class="p-3.5">Tour Package</th>
                            <th class="p-3.5">Price</th>
                            <th class="p-3.5">Duration</th>
                            <th class="p-3.5">Status</th>
                            <th class="p-3.5 text-right rounded-r-2xl">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 font-sans">
                        @foreach($allTours as $tour)
                            <tr class="hover:bg-zinc-900/50 transition" x-show="matchesSearch('{{ strtolower($tour->title . ' ' . $tour->location) }}')">
                                <td class="p-3.5">
                                    <img src="{{ asset('storage/' . $tour->cover_image) }}" class="w-14 h-10 sm:w-16 sm:h-12 rounded-xl object-cover border border-zinc-800 bg-zinc-950">
                                </td>
                                <td class="p-3.5">
                                    <span class="font-bold text-white text-xs sm:text-sm block">{{ $tour->title }}</span>
                                    <span class="text-[10px] text-zinc-500">📍 {{ $tour->location }}</span>
                                </td>
                                <td class="p-3.5 font-mono-code font-black text-emerald-400">
                                    ฿{{ number_format($tour->price) }}
                                </td>
                                <td class="p-3.5 font-mono-code text-zinc-400">
                                    {{ $tour->duration_days }}D {{ $tour->duration_nights }}N
                                </td>
                                <td class="p-3.5">
                                    @if($tour->status)
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-mono-code font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">ACTIVE</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-mono-code font-bold bg-zinc-800 text-zinc-400">DRAFT</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-right space-x-2.5 font-mono-code text-xs">
                                    <a href="{{ route('tours.show', $tour->slug) }}" target="_blank" class="text-zinc-400 hover:text-emerald-400">View ↗</a>
                                    <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this tour?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300 font-bold">Del</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>


    <!-- =========================================================================
         6. REAL REVIEWS FEED & DIAGNOSTICS
         ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">
        <div class="lg:col-span-8 glass-panel p-5 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-base sm:text-lg font-black text-white uppercase">Customer Reviews Feed</h3>
                <a href="{{ route('admin.reviews.index') }}" class="text-xs font-mono-code text-emerald-400 hover:underline">View All &rarr;</a>
            </div>

            @if($recentReviews->isEmpty())
                <p class="text-xs font-mono-code text-zinc-500 py-6 text-center">No reviews submitted yet.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentReviews as $rev)
                        <div class="bg-black/60 p-3.5 sm:p-4 rounded-2xl border border-zinc-800 flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                            <div class="space-y-1.5 flex-grow">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-bold text-white text-xs">{{ $rev->name }}</span>
                                    <span class="text-amber-400 text-xs">{{ str_repeat('★', $rev->rating) }}</span>
                                    <span class="text-[10px] font-mono-code text-zinc-500">• {{ $rev->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-zinc-300 line-clamp-2">"{{ $rev->comment }}"</p>
                            </div>
                            <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Delete review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-400 text-[11px] font-mono-code font-bold hover:bg-rose-950/40 px-2 py-1 rounded-lg">✕</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="lg:col-span-4 glass-panel p-5 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 shadow-2xl space-y-4">
            <h3 class="text-base sm:text-lg font-black text-white uppercase">System Diagnostics</h3>
            <div class="space-y-2.5 font-mono-code text-xs">
                <div class="bg-black/60 p-3 rounded-xl border border-zinc-800 flex justify-between">
                    <span class="text-zinc-400">Framework</span>
                    <span class="text-emerald-400 font-bold">Laravel 12.x</span>
                </div>
                <div class="bg-black/60 p-3 rounded-xl border border-zinc-800 flex justify-between">
                    <span class="text-zinc-400">PHP Runtime</span>
                    <span class="text-emerald-400 font-bold">PHP 8.2+</span>
                </div>
                <div class="bg-black/60 p-3 rounded-xl border border-zinc-800 flex justify-between">
                    <span class="text-zinc-400">Database Engine</span>
                    <span class="text-emerald-400 font-bold">MySQL (OK)</span>
                </div>
            </div>
        </div>
    </div>


    <!-- =========================================================================
         7. QUICK ADD TOUR MODAL
         ========================================================================= -->
    <div x-show="openQuickTourModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4">
        <div @click.away="openQuickTourModal = false" class="glass-panel border border-emerald-500/30 rounded-3xl max-w-lg w-full p-5 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800 mb-4">
                <h3 class="text-base font-black text-white uppercase">Quick Add Tour Package</h3>
                <button @click="openQuickTourModal = false" class="text-zinc-400 hover:text-white font-mono-code">✕</button>
            </div>

            <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs font-mono-code">
                @csrf
                <div>
                    <label class="block text-zinc-300 font-bold mb-1">Title *</label>
                    <input type="text" name="title" required placeholder="Tour name" class="w-full bg-black/80 text-white border border-zinc-700 rounded-xl p-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-300 font-bold mb-1">Price (฿) *</label>
                        <input type="number" name="price" required placeholder="2990" class="w-full bg-black/80 text-white border border-zinc-700 rounded-xl p-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-zinc-300 font-bold mb-1">Location *</label>
                        <input type="text" name="location" value="Surat Thani" required class="w-full bg-black/80 text-white border border-zinc-700 rounded-xl p-3">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-300 font-bold mb-1">Days *</label>
                        <input type="number" name="duration_days" value="2" min="1" required class="w-full bg-black/80 text-white border border-zinc-700 rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-zinc-300 font-bold mb-1">Nights *</label>
                        <input type="number" name="duration_nights" value="1" min="0" required class="w-full bg-black/80 text-white border border-zinc-700 rounded-xl p-3">
                    </div>
                </div>
                <div>
                    <label class="block text-zinc-300 font-bold mb-1">Cover Image *</label>
                    <input type="file" name="cover_image" required accept="image/*" class="w-full text-zinc-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-emerald-950 file:text-emerald-300 cursor-pointer">
                </div>
                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black uppercase tracking-wider py-3.5 rounded-xl shadow-lg transition">
                    Publish Package
                </button>
            </form>
        </div>
    </div>

</div>

<!-- ALPINE & DYNAMIC CHART SCRIPT -->
<script>
    function dashboardMatrix() {
        return {
            currentTime: '',
            chartRange: '30D',
            searchQuery: '',
            openQuickTourModal: false,

            chartData7D: {
                labels: @json($chart7DaysLabels),
                data: @json($chart7DaysData)
            },
            chartData30D: {
                labels: @json($chart30DaysLabels),
                data: @json($chart30DaysData)
            },
            chartData1Y: {
                labels: @json($chartYearLabels),
                data: @json($chartYearData)
            },

            init() {
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
                this.initInquiryChart();
                this.initChannelDonut();
            },

            updateTime() {
                const now = new Date();
                this.currentTime = now.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            },

            matchesSearch(text) {
                if (!this.searchQuery) return true;
                return text.includes(this.searchQuery.toLowerCase());
            },

            initInquiryChart() {
                const ctx = document.getElementById('inquiryChart').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 250);
                gradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

                window.inquiryChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.chartData30D.labels,
                        datasets: [{
                            label: 'Inquiries',
                            data: this.chartData30D.data,
                            borderColor: '#10b981',
                            borderWidth: 2.5,
                            fill: true,
                            backgroundColor: gradient,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#10b981'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { color: 'rgba(255, 255, 255, 0.04)' }, ticks: { color: '#71717a', font: { family: 'JetBrains Mono', size: 10 } } },
                            y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.04)' }, ticks: { color: '#71717a', font: { family: 'JetBrains Mono', size: 10 }, stepSize: 1 } }
                        }
                    }
                });
            },

            updateChart() {
                if (!window.inquiryChartInstance) return;
                if (this.chartRange === '7D') {
                    window.inquiryChartInstance.data.labels = this.chartData7D.labels;
                    window.inquiryChartInstance.data.datasets[0].data = this.chartData7D.data;
                } else if (this.chartRange === '30D') {
                    window.inquiryChartInstance.data.labels = this.chartData30D.labels;
                    window.inquiryChartInstance.data.datasets[0].data = this.chartData30D.data;
                } else {
                    window.inquiryChartInstance.data.labels = this.chartData1Y.labels;
                    window.inquiryChartInstance.data.datasets[0].data = this.chartData1Y.data;
                }
                window.inquiryChartInstance.update();
            },

            initChannelDonut() {
                const ctx = document.getElementById('channelDonut').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Live Webchat', 'Direct Channels'],
                        datasets: [{
                            data: [{{ max($totalInquiries, 1) }}, 1],
                            backgroundColor: ['#10b981', '#06C755'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '76%',
                        plugins: { legend: { display: false } }
                    }
                });
            }
        }
    }
</script>
@endsection