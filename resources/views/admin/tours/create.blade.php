@extends('layouts.admin')

@section('title', 'CREATE PACKAGE // RANGO TOUR ADMIN')
@section('header', 'NEW TOUR PACKAGE CREATION')

@section('content')
<div class="max-w-5xl mx-auto space-y-8" 
     x-data="{
        coverPreview: null,
        isFeatured: true,
        status: true,
        schedules: [
            { date: '{{ date('Y-m-d', strtotime('+3 days')) }}', seats: 20 },
            { date: '{{ date('Y-m-d', strtotime('+10 days')) }}', seats: 20 }
        ],
        addSchedule() {
            this.schedules.push({ date: '', seats: 20 });
        },
        removeSchedule(index) {
            if (this.schedules.length > 1) {
                this.schedules.splice(index, 1);
            }
        },
        fileChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.coverPreview = URL.createObjectURL(file);
            }
        }
     }">

    <!-- Top Navigation & Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.tours.index') }}" class="text-xs font-mono-code text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                    <span>&larr;</span> Back to Tour Inventory
                </a>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Deploy New Tour Package</h2>
            <p class="text-xs text-zinc-400 font-mono-code">Fill in pricing, itineraries, visual media, and automated booking schedules.</p>
        </div>

        <a href="{{ route('admin.tours.index') }}" class="self-start sm:self-auto px-4 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 font-mono-code text-xs font-bold transition">
            Discard Changes ✕
        </a>
    </div>

    <!-- Main Creation Form Container -->
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- =========================================================================
             SECTION 1: PRIMARY SPECIFICATIONS (Title, Price, Location, Duration)
             ========================================================================= -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">01</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Primary Specifications</h3>
                </div>
                <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">REQUIRED CORE DATA</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <!-- Tour Title (8 cols) -->
                <div class="md:col-span-8">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Tour Package Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Khao Sok Rainforest & Floating Villa Experience" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <!-- Price (4 cols) -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-mono-code font-bold text-emerald-400 mb-2 uppercase">Price Per Person (฿) *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-4 font-mono-code font-bold text-zinc-500 text-xs">฿</span>
                        <input type="number" name="price" required placeholder="3200" 
                               class="w-full bg-black/80 text-emerald-300 font-mono-code font-bold placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-2xl p-4 pl-9 text-xs focus:outline-none transition">
                    </div>
                </div>

                <!-- Location (6 cols) -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Destination & Location *</label>
                    <input type="text" name="location" required value="Khao Sok, Surat Thani, Thailand" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <!-- Duration Days (3 cols) -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Duration Days *</label>
                    <input type="number" name="duration_days" value="2" min="1" max="30" required 
                           class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs text-center focus:outline-none transition">
                </div>

                <!-- Duration Nights (3 cols) -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Duration Nights *</label>
                    <input type="number" name="duration_nights" value="1" min="0" max="30" required 
                           class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs text-center focus:outline-none transition">
                </div>
            </div>
        </div>


        <!-- =========================================================================
             SECTION 2: VISUAL MEDIA & COVER ASSET
             ========================================================================= -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-400 font-mono-code font-bold text-xs flex items-center justify-center">02</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Visual Media Asset</h3>
                </div>
                <span class="text-[10px] font-mono-code text-zinc-500">JPG, PNG, WEBP (MAX 5MB)</span>
            </div>

            <!-- Drag & Drop Upload Zone with Preview -->
            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">High-Resolution Cover Photo *</label>
                
                <div class="relative rounded-2xl sm:rounded-3xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 transition group text-center cursor-pointer overflow-hidden">
                    <input type="file" name="cover_image" required accept="image/*" @change="fileChosen" 
                           class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">

                    <!-- Default Empty State -->
                    <div x-show="!coverPreview" class="space-y-3 py-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-2xl group-hover:scale-110 transition duration-300 shadow-lg">
                            📸
                        </div>
                        <div>
                            <p class="text-xs font-bold text-white uppercase tracking-wider">Click or Drag & Drop Cover Image Here</p>
                            <p class="text-[11px] font-mono-code text-zinc-500 mt-1">Recommended size: 1920x1080px landscape aspect ratio</p>
                        </div>
                    </div>

                    <!-- Live Image Preview Container -->
                    <template x-if="coverPreview">
                        <div class="relative h-64 sm:h-80 w-full rounded-2xl overflow-hidden border border-zinc-700 shadow-xl group">
                            <img :src="coverPreview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-xs font-mono-code text-emerald-400 font-bold">
                                <span>Click anywhere to replace image</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>


        <!-- =========================================================================
             SECTION 3: NARRATIVE, ITINERARY & PACKAGE DETAILS
             ========================================================================= -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">03</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Narrative & Inclusions Matrix</h3>
                </div>
                <span class="text-[10px] font-mono-code text-zinc-500 uppercase">EXPERIENCE ARCHITECTURE</span>
            </div>

            <div class="space-y-5">
                <!-- Short Description -->
                <div>
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Short Narrative Summary</label>
                    <textarea name="description" rows="3" placeholder="Brief enticing overview of what travelers will experience on this trip..." 
                              class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition leading-relaxed"></textarea>
                </div>

                <!-- Daily Itinerary -->
                <div>
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Day-by-Day Detailed Itinerary</label>
                    <textarea name="itinerary" rows="6" placeholder="Day 1:&#10;08:30 - Pick up from pier & scenic boat journey across Cheow Lan Lake&#10;12:00 - Check-in at floating raft house & authentic local lunch&#10;14:00 - Guided jungle trek & bamboo rafting to Pakarang Cave&#10;&#10;Day 2:&#10;06:30 - Morning wildlife safari boat ride&#10;08:00 - Breakfast & leisure kayaking&#10;10:30 - Return boat transfer to mainland pier" 
                              class="w-full bg-black/80 text-zinc-200 placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-mono-code focus:outline-none transition leading-relaxed"></textarea>
                </div>

                <!-- Inclusions vs Exclusions Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <!-- Inclusions -->
                    <div class="p-5 rounded-2xl bg-emerald-950/20 border border-emerald-500/20 space-y-2">
                        <label class="block text-xs font-mono-code font-bold text-emerald-400 uppercase flex items-center gap-1.5">
                            <span>✅</span> Included in Package
                        </label>
                        <textarea name="included" rows="5" placeholder="• Private longtail boat transfer&#10;• 3 full-board Southern Thai meals&#10;• Certified English-speaking tour guide&#10;• Kayak rental & safety equipment&#10;• Travel insurance coverage" 
                                  class="w-full bg-black/70 text-emerald-200 placeholder-emerald-900/60 border border-emerald-900/40 focus:border-emerald-500 rounded-xl p-3 text-xs font-mono-code focus:outline-none transition leading-relaxed"></textarea>
                    </div>

                    <!-- Exclusions -->
                    <div class="p-5 rounded-2xl bg-rose-950/20 border border-rose-500/20 space-y-2">
                        <label class="block text-xs font-mono-code font-bold text-rose-400 uppercase flex items-center gap-1.5">
                            <span>❌</span> Excluded / Optional Fees
                        </label>
                        <textarea name="excluded" rows="5" placeholder="• Khao Sok National Park entry fee (฿300/foreigner)&#10;• Personal expenses & alcoholic beverages&#10;• Airport van transfer to mainland pier" 
                                  class="w-full bg-black/70 text-rose-200 placeholder-rose-900/60 border border-rose-900/40 focus:border-rose-500 rounded-xl p-3 text-xs font-mono-code focus:outline-none transition leading-relaxed"></textarea>
                    </div>
                </div>
            </div>
        </div>


        <!-- =========================================================================
             SECTION 4: DEPARTURE SCHEDULE MATRIX (Dynamic Repeater Engine)
             ========================================================================= -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">04</span>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">Automated Departure Schedules</h3>
                        <p class="text-[11px] font-mono-code text-zinc-500">Guests will choose from these departure dates during instant chat booking.</p>
                    </div>
                </div>

                <button type="button" @click="addSchedule()" 
                        class="px-4 py-2 rounded-xl bg-emerald-500/20 hover:bg-emerald-500 text-emerald-300 hover:text-black border border-emerald-500/40 font-mono-code text-xs font-bold transition flex items-center gap-1.5 shrink-0 self-start sm:self-auto">
                    <span>+</span> Add Another Date
                </button>
            </div>

            <!-- Dynamic Date Repeater Rows -->
            <div class="space-y-3">
                <template x-for="(item, index) in schedules" :key="index">
                    <div class="bg-black/60 border border-zinc-800/80 p-4 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:border-emerald-500/30 transition">
                        <div class="flex items-center gap-3 flex-grow">
                            <span class="w-6 text-center font-mono-code text-xs font-bold text-zinc-500" x-text="'#' + (index + 1)"></span>
                            
                            <!-- Travel Date Input -->
                            <div class="flex-grow">
                                <label class="block text-[10px] font-mono-code text-zinc-400 uppercase mb-1">Departure Date</label>
                                <input type="date" name="schedule_dates[]" x-model="item.date" required 
                                       class="w-full bg-zinc-950 text-white border border-zinc-700 focus:border-emerald-500 rounded-xl p-2.5 text-xs font-mono-code focus:outline-none">
                            </div>

                            <!-- Seats Available Input -->
                            <div class="w-32 sm:w-40">
                                <label class="block text-[10px] font-mono-code text-zinc-400 uppercase mb-1">Seats Capacity</label>
                                <input type="number" name="schedule_seats[]" x-model="item.seats" min="1" max="100" required 
                                       class="w-full bg-zinc-950 text-emerald-400 font-bold border border-zinc-700 focus:border-emerald-500 rounded-xl p-2.5 text-xs font-mono-code text-center focus:outline-none">
                            </div>
                        </div>

                        <!-- Remove Row Button -->
                        <button type="button" @click="removeSchedule(index)" 
                                :disabled="schedules.length <= 1"
                                class="p-2.5 text-zinc-500 hover:text-rose-400 hover:bg-rose-500/10 rounded-xl transition disabled:opacity-30 disabled:pointer-events-none self-end sm:self-center" title="Delete Row">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>


        <!-- =========================================================================
             SECTION 5: PUBLISHING VISIBILITY TOGGLES & SUBMIT
             ========================================================================= -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Featured Toggle -->
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="is_featured" value="1" x-model="isFeatured" class="w-5 h-5 text-emerald-500 bg-black border-zinc-700 rounded focus:ring-emerald-500">
                    <div>
                        <span class="text-xs font-bold text-white block uppercase">Featured on Homepage</span>
                        <span class="text-[10px] font-mono-code text-zinc-400">Show in luxury package showcases</span>
                    </div>
                </label>

                <!-- Active Status Toggle -->
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="status" value="1" x-model="status" class="w-5 h-5 text-emerald-500 bg-black border-zinc-700 rounded focus:ring-emerald-500">
                    <div>
                        <span class="text-xs font-bold text-white block uppercase">Active & Open for Booking</span>
                        <span class="text-[10px] font-mono-code text-zinc-400">Instantly visible in tour catalogue</span>
                    </div>
                </label>
            </div>

            <!-- Publish Button -->
            <button type="submit" 
                    class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black uppercase text-xs tracking-wider rounded-2xl shadow-xl shadow-emerald-500/30 hover:scale-[1.02] active:scale-95 transition duration-200 flex items-center justify-center gap-2">
                <span>🚀</span> Deploy & Publish Tour
            </button>
        </div>
    </form>
</div>
@endsection