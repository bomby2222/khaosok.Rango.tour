@extends('layouts.admin')

@section('title', 'EDIT TOUR PACKAGE // RANGO TOUR ADMIN')
@section('header', 'EDIT TOUR PACKAGE')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" 
     x-data="{
        imagePreview: '{{ $tour->cover_image ? asset('storage/' . $tour->cover_image) : '' }}',
        status: {{ $tour->status ? 'true' : 'false' }},
        is_featured: {{ $tour->is_featured ? 'true' : 'false' }},
        fileChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagePreview = URL.createObjectURL(file);
            }
        }
     }">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.tours.index') }}" class="text-xs font-mono-code text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                    <span>&larr;</span> Back to Tour Inventory
                </a>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Edit Tour: {{ $tour->title }}</h2>
            <p class="text-xs text-zinc-400 font-mono-code">Update itinerary, pricing, duration, features, and showcase cover.</p>
        </div>

        <a href="{{ route('admin.tours.index') }}" class="self-start sm:self-auto px-4 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 font-mono-code text-xs font-bold transition">
            Discard Changes ✕
        </a>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: CORE IDENTIFIERS & PRICING -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">01</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Package Identifiers &amp; Pricing</h3>
                </div>
                <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">REQUIRED CORE DATA</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <!-- Tour Title -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Tour Package Title *</label>
                    <input type="text" name="title" required value="{{ old('title', $tour->title) }}" placeholder="e.g. 3D2N Ultimate Lake & Cave Expedition" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <!-- Location -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Location / Meeting Point *</label>
                    <input type="text" name="location" required value="{{ old('location', $tour->location) }}" placeholder="e.g. Cheow Lan Lake, Surat Thani" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <!-- Price -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-emerald-400 mb-2 uppercase">Price Per Person (THB) *</label>
                    <input type="number" name="price" step="0.01" min="0" required value="{{ old('price', $tour->price) }}" placeholder="e.g. 6900" 
                           class="w-full bg-black/80 text-emerald-400 font-mono-code font-bold border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs focus:outline-none transition">
                </div>

                <!-- Days -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Duration (Days) *</label>
                    <input type="number" name="duration_days" min="1" required value="{{ old('duration_days', $tour->duration_days) }}" 
                           class="w-full bg-black/80 text-white font-mono-code text-center border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs focus:outline-none transition">
                </div>

                <!-- Nights -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Duration (Nights) *</label>
                    <input type="number" name="duration_nights" min="0" required value="{{ old('duration_nights', $tour->duration_nights) }}" 
                           class="w-full bg-black/80 text-white font-mono-code text-center border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs focus:outline-none transition">
                </div>
            </div>
        </div>

        <!-- SECTION 2: DESCRIPTION & ITINERARY -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-400 font-mono-code font-bold text-xs flex items-center justify-center">02</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Itinerary Narrative &amp; Highlights</h3>
                </div>
                <span class="text-[10px] font-mono-code text-zinc-500 uppercase">FULL DESCRIPTION</span>
            </div>

            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Short Summary &amp; Overview *</label>
                <textarea name="description" rows="4" required placeholder="Brief overview shown on cards and previews..." 
                          class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition leading-relaxed">{{ old('description', $tour->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Day-by-Day Detailed Itinerary</label>
                <textarea name="itinerary" rows="6" placeholder="Day 1: Arrival & boat cruise... Day 2: Cave hiking & wildlife safari..." 
                          class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition leading-relaxed">{{ old('itinerary', $tour->itinerary) }}</textarea>
            </div>
        </div>

        <!-- SECTION 3: COVER MEDIA -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">03</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Tour Cover Photo</h3>
                </div>
                <span class="text-[10px] font-mono-code text-zinc-500 uppercase">JPG, PNG, WEBP (LEAVE BLANK TO KEEP CURRENT)</span>
            </div>

            <div>
                <div class="relative rounded-2xl sm:rounded-3xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 transition group text-center cursor-pointer overflow-hidden">
                    <input type="file" name="cover_image" accept="image/*" @change="fileChosen" class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">

                    <template x-if="imagePreview">
                        <div class="relative h-64 sm:h-72 w-full rounded-2xl overflow-hidden border border-zinc-700 shadow-xl group">
                            <img :src="imagePreview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-xs font-mono-code text-emerald-400 font-bold">
                                <span>Click anywhere to replace cover photo</span>
                            </div>
                        </div>
                    </template>

                    <div x-show="!imagePreview" class="space-y-3 py-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-2xl shadow-lg">🧭</div>
                        <p class="text-xs font-bold text-white uppercase tracking-wider">Click or Drag &amp; Drop Image Here</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: TOGGLES & SUBMIT -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Status Toggle -->
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="status" value="1" x-model="status" class="w-5 h-5 text-emerald-500 bg-black border-zinc-700 rounded focus:ring-emerald-500">
                    <div>
                        <span class="text-xs font-bold text-white block uppercase">Open for Booking</span>
                        <span class="text-[10px] font-mono-code text-zinc-400">Available on website</span>
                    </div>
                </label>

                <!-- Featured Toggle -->
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="is_featured" value="1" x-model="is_featured" class="w-5 h-5 text-amber-500 bg-black border-zinc-700 rounded focus:ring-amber-500">
                    <div>
                        <span class="text-xs font-bold text-amber-400 block uppercase">Featured Package</span>
                        <span class="text-[10px] font-mono-code text-zinc-400">Showcase on homepage</span>
                    </div>
                </label>
            </div>

            <button type="submit" 
                    class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black uppercase text-xs tracking-wider rounded-2xl shadow-xl shadow-emerald-500/30 hover:scale-[1.02] active:scale-95 transition duration-200 flex items-center justify-center gap-2">
                <span>💾</span> Update Tour Package
            </button>
        </div>
    </form>
</div>
@endsection