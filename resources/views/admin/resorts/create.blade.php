@extends('layouts.admin')

@section('title', 'ADD LAKE RESORT // RANGO ADMIN')
@section('header', 'NEW LAKE RESORT CREATION')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" 
     x-data="{
        imagePreview: null,
        galleryCount: 0,
        status: true,
        fileChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagePreview = URL.createObjectURL(file);
            }
        },
        galleryChosen(event) {
            this.galleryCount = event.target.files.length;
        }
     }">

    <!-- Top Action & Navigation Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.resorts.index') }}" class="text-xs font-mono-code text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                    <span>&larr;</span> Back to Lake Resorts
                </a>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Deploy New Lake Resort</h2>
            <p class="text-xs text-zinc-400 font-mono-code">Add floating bungalows and overwater villas with up to 10 gallery photos.</p>
        </div>

        <a href="{{ route('admin.resorts.index') }}" class="self-start sm:self-auto px-4 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 font-mono-code text-xs font-bold transition">
            Discard Changes ✕
        </a>
    </div>

    <!-- Main Creation Form -->
    <form action="{{ route('admin.resorts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- SECTION 1: PRIMARY IDENTIFIERS -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">01</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Resort Identifiers</h3>
                </div>
                <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">REQUIRED CORE DATA</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Prefix (คำโปรยด้านบน)</label>
                    <input type="text" name="prefix" value="{{ old('prefix') }}" placeholder="e.g. CHEOW LAN LAKE or THE" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Sort Order (ลำดับแสดงผล)</label>
                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}" 
                           class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs text-center focus:outline-none transition">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Resort Main Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. The Laguna Chiewlan" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Subtitle (คำต่อท้าย)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="e.g. OVERWATER BUNGALOW" 
                           class="w-full bg-black/80 text-emerald-400 font-bold placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>
            </div>
        </div>

        <!-- SECTION 2: COVER PHOTO (ASPECT 3:4) -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-400 font-mono-code font-bold text-xs flex items-center justify-center">02</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Main Cover Photo</h3>
                </div>
                <span class="text-[10px] font-mono-code text-zinc-500 uppercase">ASPECT RATIO 3:4 (MAX 4MB)</span>
            </div>

            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Resort Cover Photo *</label>
                <div class="relative rounded-2xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 transition text-center cursor-pointer overflow-hidden">
                    <input type="file" name="image" required accept="image/*" @change="fileChosen" class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">

                    <div x-show="!imagePreview" class="space-y-3 py-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-2xl shadow-lg">🛶</div>
                        <p class="text-xs font-bold text-white uppercase tracking-wider">Click or Drag &amp; Drop Main Cover Photo</p>
                        <p class="text-[11px] font-mono-code text-zinc-500 mt-1">Recommended: 600x800px Portrait</p>
                    </div>

                    <template x-if="imagePreview">
                        <div class="relative h-64 sm:h-72 w-full rounded-2xl overflow-hidden border border-zinc-700 shadow-xl">
                            <img :src="imagePreview" class="w-full h-full object-cover">
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- SECTION 3: 10-SLIDE GALLERY PHOTOS (NEW!) -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">03</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Slide Gallery Media</h3>
                </div>
                <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">MAXIMUM 10 PHOTOS</span>
            </div>

            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">
                    Upload Additional Photos for 10-Slide Lightbox (เลือกได้หลายรูปพร้อมกัน)
                </label>
                
                <div class="relative rounded-2xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 transition text-center cursor-pointer">
                    <input type="file" name="gallery[]" multiple accept="image/*" @change="galleryChosen" 
                           class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">

                    <div class="space-y-2 py-4">
                        <span class="text-3xl block">📸</span>
                        <p class="text-xs font-bold text-white uppercase">Choose up to 10 Images for Lightbox Slider</p>
                        <p class="text-[11px] font-mono-code text-zinc-500">Hold Ctrl (or Cmd) to select multiple files</p>
                        <div x-show="galleryCount > 0" class="pt-2">
                            <span class="inline-block px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 rounded-full text-xs font-mono-code font-bold">
                                Selected: <span x-text="galleryCount"></span> photos
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: DEPLOYMENT & TOGGLES -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <label class="flex items-center gap-3 cursor-pointer select-none">
                <input type="checkbox" name="status" value="1" x-model="status" class="w-5 h-5 text-emerald-500 bg-black border-zinc-700 rounded focus:ring-emerald-500">
                <div>
                    <span class="text-xs font-bold text-white block uppercase">Active Resort</span>
                    <span class="text-[10px] font-mono-code text-zinc-400">Instantly visible in the homepage showcase grid</span>
                </div>
            </label>

            <button type="submit" 
                    class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black uppercase text-xs tracking-wider rounded-2xl shadow-xl shadow-emerald-500/30 hover:scale-[1.02] active:scale-95 transition duration-200 flex items-center justify-center gap-2">
                <span>🛶</span> Deploy Lake Resort
            </button>
        </div>
    </form>
</div>
@endsection