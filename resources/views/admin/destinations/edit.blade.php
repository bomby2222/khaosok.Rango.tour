@extends('layouts.admin')

@section('title', 'EDIT BEST TOUR // RANGO TOUR ADMIN')
@section('header', 'EDIT DESTINATION & LANDMARK')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" 
     x-data="{
        imagePreview: '{{ $destination->image ? asset('storage/' . $destination->image) : '' }}',
        status: {{ $destination->status ? 'true' : 'false' }},
        fileChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagePreview = URL.createObjectURL(file);
            }
        }
     }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.destinations.index') }}" class="text-xs font-mono-code text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                    <span>&larr;</span> Back to Best Tours
                </a>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Edit Destination: {{ $destination->name }}</h2>
            <p class="text-xs text-zinc-400 font-mono-code">Update title, detailed description narrative, ordering, or replace destination imagery.</p>
        </div>

        <a href="{{ route('admin.destinations.index') }}" class="self-start sm:self-auto px-4 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 font-mono-code text-xs font-bold transition">
            Discard Changes ✕
        </a>
    </div>

    <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">01</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Primary Identifiers</h3>
                </div>
                <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">REQUIRED CORE DATA</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <div class="md:col-span-12">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Destination / Landmark Title *</label>
                    <input type="text" name="name" required 
                           value="{{ old('name', $destination->name) }}" 
                           placeholder="e.g. Khao Sam Kloe or Bamboo Rafting" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <div class="md:col-span-8">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Region / Country *</label>
                    <input type="text" name="country" required 
                           value="{{ old('country', $destination->country ?? 'Thailand') }}" 
                           class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Sort Order (ลำดับแสดงผล)</label>
                    <input type="number" name="sort_order" min="0" 
                           value="{{ old('sort_order', $destination->sort_order ?? 0) }}" 
                           class="w-full bg-black/80 text-white font-mono-code border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs text-center focus:outline-none transition">
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-400 font-mono-code font-bold text-xs flex items-center justify-center">02</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Atmosphere Narrative &amp; Story</h3>
                </div>
                <span class="text-[10px] font-mono-code text-zinc-500 uppercase">MODAL EXPLANATION TEXT</span>
            </div>

            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Full Description &amp; Highlights (แสดงใต้ภาพเวลาคลิก)</label>
                <textarea name="description" rows="6" 
                          placeholder="Describe the limestone cliffs, crystal emerald water, bamboo rafting sensations, and wildlife..." 
                          class="w-full bg-black/80 text-white placeholder-zinc-600 border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none transition leading-relaxed">{{ old('description', $destination->description) }}</textarea>
                <span class="text-[10px] font-mono-code text-zinc-500 mt-1 block">💡 You can use bullet points (•) and line breaks. They will be formatted cleanly in the popup modal.</span>
            </div>
        </div>

        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">03</span>
                    <h3 class="text-sm font-black text-white uppercase tracking-wider">Visual Media Asset</h3>
                </div>
                <span class="text-[10px] font-mono-code text-zinc-500 uppercase">JPG, PNG, WEBP (LEAVE BLANK TO KEEP CURRENT)</span>
            </div>

            <div>
                <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Destination Photo</label>
                
                <div class="relative rounded-2xl sm:rounded-3xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 transition group text-center cursor-pointer overflow-hidden">
                    <input type="file" name="image" accept="image/*" @change="fileChosen" 
                           class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">

                    <template x-if="imagePreview">
                        <div class="relative h-64 sm:h-72 w-full rounded-2xl overflow-hidden border border-zinc-700 shadow-xl group">
                            <img :src="imagePreview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-xs font-mono-code text-emerald-400 font-bold">
                                <span>Click anywhere to upload a new replacement image</span>
                            </div>
                        </div>
                    </template>

                    <div x-show="!imagePreview" class="space-y-3 py-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-2xl shadow-lg">
                            🏝️
                        </div>
                        <p class="text-xs font-bold text-white uppercase tracking-wider">Click or Drag &amp; Drop Image Here</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <label class="flex items-center gap-3 cursor-pointer select-none">
                <input type="checkbox" name="status" value="1" x-model="status" class="w-5 h-5 text-emerald-500 bg-black border-zinc-700 rounded focus:ring-emerald-500">
                <div>
                    <span class="text-xs font-bold text-white block uppercase">Active Showcase</span>
                    <span class="text-[10px] font-mono-code text-zinc-400">Visible on the website's Best Tours page</span>
                </div>
            </label>

            <button type="submit" 
                    class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black uppercase text-xs tracking-wider rounded-2xl shadow-xl shadow-emerald-500/30 hover:scale-[1.02] active:scale-95 transition duration-200 flex items-center justify-center gap-2">
                <span>💾</span> Update Destination
            </button>
        </div>
    </form>
</div>
@endsection