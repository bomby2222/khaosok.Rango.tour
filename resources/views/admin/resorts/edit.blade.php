@extends('layouts.admin')

@section('title', 'EDIT LAKE RESORT // RANGO ADMIN')
@section('header', 'EDIT LAKE RESORT')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" 
     x-data="{
        imagePreview: '{{ $resort->image ? asset('storage/' . $resort->image) : '' }}',
        newGalleryCount: 0,
        status: {{ $resort->status ? 'true' : 'false' }},
        fileChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagePreview = URL.createObjectURL(file);
            }
        },
        galleryChosen(event) {
            this.newGalleryCount = event.target.files.length;
        }
     }">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.resorts.index') }}" class="text-xs font-mono-code text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                    <span>&larr;</span> Back to Lake Resorts
                </a>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Edit Resort: {{ $resort->name }}</h2>
            <p class="text-xs text-zinc-400 font-mono-code">Update title, cover image, and manage the 10-slide lightbox gallery photos.</p>
        </div>

        <a href="{{ route('admin.resorts.index') }}" class="self-start sm:self-auto px-4 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 font-mono-code text-xs font-bold transition">
            Discard Changes ✕
        </a>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.resorts.update', $resort->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: IDENTIFIERS -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Prefix (คำโปรยด้านบน)</label>
                    <input type="text" name="prefix" value="{{ old('prefix', $resort->prefix) }}" placeholder="e.g. CHEOW LAN LAKE" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Sort Order (ลำดับแสดงผล)</label>
                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $resort->sort_order ?? 0) }}" 
                           class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs text-center focus:outline-none transition">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Resort Main Name *</label>
                    <input type="text" name="name" required value="{{ old('name', $resort->name) }}" placeholder="e.g. The Laguna Chiewlan" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Subtitle (คำต่อท้าย)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $resort->subtitle) }}" placeholder="e.g. OVERWATER BUNGALOW" 
                           class="w-full bg-black/80 text-emerald-400 font-bold placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>
            </div>
        </div>

        <!-- SECTION 2: COVER PHOTO -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <h3 class="text-sm font-black text-white uppercase tracking-wider pb-3 border-b border-zinc-800">
                02. Main Cover Photo (Aspect 3:4)
            </h3>
            <div>
                <div class="relative rounded-2xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 transition text-center cursor-pointer overflow-hidden">
                    <input type="file" name="image" accept="image/*" @change="fileChosen" class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">

                    <template x-if="imagePreview">
                        <div class="relative h-64 sm:h-72 w-full rounded-2xl overflow-hidden border border-zinc-700 shadow-xl group">
                            <img :src="imagePreview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-xs font-mono-code text-emerald-400 font-bold">
                                <span>Click anywhere to replace cover image</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- SECTION 3: 10-SLIDE GALLERY PHOTOS (NEW!) -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                <h3 class="text-sm font-black text-white uppercase tracking-wider">
                    03. 10-Slide Lightbox Gallery Media
                </h3>
                <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">
                    Current: {{ is_array($resort->gallery) ? count($resort->gallery) : 0 }} / 10 Photos
                </span>
            </div>

            <!-- Existing Gallery Photos List -->
            @if(is_array($resort->gallery) && count($resort->gallery) > 0)
                <div class="space-y-3">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 uppercase">
                        Current Gallery Photos (Check box to delete):
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3">
                        @foreach($resort->gallery as $galImg)
                            <div class="relative group rounded-xl overflow-hidden border border-zinc-800 bg-black aspect-video">
                                <img src="{{ asset('storage/' . $galImg) }}" class="w-full h-full object-cover">
                                <label class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center cursor-pointer text-center p-2">
                                    <input type="checkbox" name="delete_gallery[]" value="{{ $galImg }}" class="w-4 h-4 text-rose-500 rounded border-zinc-700 focus:ring-rose-500">
                                    <span class="text-[10px] font-mono-code text-rose-400 font-bold mt-1">Delete</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Upload More Gallery Photos -->
            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">
                    Upload Additional Photos (Up to 10 photos total)
                </label>
                <div class="relative rounded-2xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 transition text-center cursor-pointer">
                    <input type="file" name="gallery[]" multiple accept="image/*" @change="galleryChosen" 
                           class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">

                    <div class="space-y-2 py-4">
                        <span class="text-3xl block">📸</span>
                        <p class="text-xs font-bold text-white uppercase">Choose Photos to Add</p>
                        <p class="text-[11px] font-mono-code text-zinc-500">Select multiple files (Ctrl/Cmd + Click)</p>
                        <div x-show="newGalleryCount > 0" class="pt-2">
                            <span class="inline-block px-3 py-1 bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 rounded-full text-xs font-mono-code font-bold">
                                Ready to upload: <span x-text="newGalleryCount"></span> photos
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: SUBMIT BAR -->
        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <label class="flex items-center gap-3 cursor-pointer select-none">
                <input type="checkbox" name="status" value="1" x-model="status" class="w-5 h-5 text-emerald-500 bg-black border-zinc-700 rounded focus:ring-emerald-500">
                <div>
                    <span class="text-xs font-bold text-white block uppercase">Active Resort</span>
                    <span class="text-[10px] font-mono-code text-zinc-400">Visible on the homepage</span>
                </div>
            </label>

            <button type="submit" 
                    class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black uppercase text-xs tracking-wider rounded-2xl shadow-xl shadow-emerald-500/30 hover:scale-[1.02] active:scale-95 transition duration-200 flex items-center justify-center gap-2">
                <span>💾</span> Update Lake Resort
            </button>
        </div>
    </form>
</div>
@endsection