@extends('layouts.admin')

@section('header', 'Upload New Banner Slide')

@section('content')
    <div class="max-w-2xl bg-neutral-900 rounded-3xl border border-neutral-800 p-6 sm:p-8 shadow-xl">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-neutral-300 mb-1">Headline Title *</label>
                <input type="text" name="title" required placeholder="e.g. Explore Emerald Rainforests" class="w-full bg-neutral-950 text-white border border-neutral-700 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-neutral-300 mb-1">Sub-headline / Description</label>
                <textarea name="subtitle" rows="3" placeholder="Short intro text for the slide..." class="w-full bg-neutral-950 text-white border border-neutral-700 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-neutral-300 mb-1">Banner Image (High Resolution) *</label>
                <input type="file" name="image" required accept="image/*" class="w-full text-xs text-neutral-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-950 file:text-emerald-300 hover:file:bg-emerald-800 cursor-pointer">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-neutral-300 mb-1">Button Text</label>
                    <input type="text" name="button_text" value="Explore Now" class="w-full bg-neutral-950 text-white border border-neutral-700 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-neutral-300 mb-1">Button Link URL</label>
                    <input type="text" name="button_link" value="/tours" class="w-full bg-neutral-950 text-white border border-neutral-700 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="status" value="1" checked class="w-4 h-4 text-emerald-600 bg-neutral-950 border-neutral-700 rounded">
                <label class="text-xs font-semibold text-neutral-300">Set as Active Slide</label>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-neutral-950 font-black uppercase tracking-wider py-3.5 px-4 rounded-xl text-xs transition">
                Upload & Publish Slide
            </button>
        </form>
    </div>
@endsection