@extends('layouts.app')

@section('title', 'Khao Sok Rango Tour - Luxury Lake & Wildlife Experiences')

@section('content')
<div x-data="homepageManager()" @keydown.escape.window="closeGallery()" @keydown.left.window="if(galleryModal) prevGallery()" @keydown.right.window="if(galleryModal) nextGallery()">

    <!-- =========================================================================
         0. WELCOME VIDEO POPUP MODAL (Lock Screen + Autoplay No Pause)
         ========================================================================= -->
    @if(($settings['popup_video_status'] ?? '0') == '1' && !empty($settings['popup_video_file']))
    <div x-show="showVideoModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-xl p-4 select-none">
        
        <div x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-neutral-900 border border-emerald-500/30 rounded-3xl max-w-md sm:max-w-lg w-full overflow-hidden shadow-2xl flex flex-col justify-between">
            
            <div class="p-4 sm:p-5 bg-black/85 border-b border-neutral-800 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-mono-code font-bold uppercase tracking-widest text-emerald-400">
                        {{ $settings['popup_video_badge'] ?? 'RANGO TOUR HIGHLIGHT' }}
                    </span>
                </div>
                <button type="button" @click="closeVideoModal()" 
                        class="w-8 h-8 rounded-full bg-neutral-800 hover:bg-neutral-700 text-neutral-300 hover:text-white flex items-center justify-center font-mono-code text-sm transition">
                    ✕
                </button>
            </div>

            <div class="relative aspect-video sm:aspect-[4/3] bg-black overflow-hidden flex items-center justify-center pointer-events-none">
                <video id="rangoWelcomeVideo" 
                       class="w-full h-full object-cover" 
                       autoplay 
                       muted 
                       loop 
                       playsinline>
                    <source src="{{ asset('storage/' . $settings['popup_video_file']) }}" type="video/mp4">
                    Your browser does not support HTML video.
                </video>
            </div>

            <div class="p-4 sm:p-5 bg-black/90 border-t border-neutral-800 space-y-3">
                <h4 class="text-xs sm:text-sm font-black text-white leading-tight">
                    {{ $settings['popup_video_title'] ?? 'Discover Luxury Nature Adventures with Rango Tour' }}
                </h4>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-mono-code text-neutral-400 hover:text-neutral-200">
                        <input type="checkbox" x-model="dontShowAgain" class="w-4 h-4 rounded text-emerald-500 bg-neutral-800 border-neutral-700 focus:ring-emerald-500">
                        <span>Don't show this again</span>
                    </label>

                    <button type="button" @click="closeVideoModal()" 
                            class="px-5 py-2 bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg transition">
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>
    @endif

    <!-- =========================================================================
         LIGHTBOX SLIDER MODAL (กด 1 ภาพ โชว์สไลด์ต่อเนื่องสูงสุด 10 ภาพจริง)
         ========================================================================= -->
    <div x-show="galleryModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-2xl p-3 sm:p-6 select-none">
        
        <div class="relative w-full max-w-5xl h-[85vh] flex flex-col justify-between" @click.away="closeGallery()">
            
            <!-- Top Lightbox Header -->
            <div class="flex items-center justify-between text-white pb-3 border-b border-neutral-800 shrink-0">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                    <div>
                        <h4 class="text-sm sm:text-base font-black uppercase text-white tracking-wide" x-text="activeGalleryTitle"></h4>
                        <span class="text-[11px] font-mono-code text-emerald-400">
                            Image <span x-text="galleryIndex + 1"></span> of <span x-text="galleryImages.length"></span>
                        </span>
                    </div>
                </div>
                <button type="button" @click="closeGallery()" 
                        class="w-10 h-10 rounded-full bg-neutral-900 hover:bg-neutral-800 border border-neutral-700 text-neutral-300 hover:text-white flex items-center justify-center text-lg font-mono-code transition">
                    ✕
                </button>
            </div>

            <!-- Main Viewing Area with Left/Right Navigation -->
            <div class="relative flex-grow flex items-center justify-center overflow-hidden my-3">
                
                <!-- Left Nav Arrow -->
                <button type="button" @click="prevGallery()" 
                        class="absolute left-2 sm:left-4 z-20 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-black/70 hover:bg-emerald-500 hover:text-neutral-950 text-white border border-neutral-700/80 flex items-center justify-center text-xl transition-all duration-200">
                    ❮
                </button>

                <!-- Active Image -->
                <div class="w-full h-full flex items-center justify-center p-2">
                    <img :src="galleryImages[galleryIndex]" 
                         class="max-w-full max-h-[62vh] object-contain rounded-2xl shadow-2xl border border-neutral-800 transition-all duration-300">
                </div>

                <!-- Right Nav Arrow -->
                <button type="button" @click="nextGallery()" 
                        class="absolute right-2 sm:right-4 z-20 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-black/70 hover:bg-emerald-500 hover:text-neutral-950 text-white border border-neutral-700/80 flex items-center justify-center text-xl transition-all duration-200">
                    ❯
                </button>
            </div>

            <!-- Bottom Thumbnails Bar -->
            <div class="flex items-center justify-center gap-2 overflow-x-auto py-2 shrink-0 max-w-full">
                <template x-for="(img, idx) in galleryImages" :key="idx">
                    <button type="button" @click="galleryIndex = idx" 
                            :class="galleryIndex === idx ? 'border-emerald-400 scale-105 opacity-100 ring-2 ring-emerald-500/50' : 'border-neutral-800 opacity-40 hover:opacity-80'"
                            class="w-14 h-11 sm:w-20 sm:h-14 rounded-xl overflow-hidden border-2 transition-all shrink-0">
                        <img :src="img" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>

        </div>
    </div>


    <!-- =========================================================================
         1. HERO 3-SLIDE IMAGE SLIDER
         ========================================================================= -->
    <section class="relative bg-black overflow-hidden select-none cursor-grab active:cursor-grabbing" 
             x-data="{ 
                activeSlide: 0, 
                totalSlides: {{ $banners->count() > 0 ? $banners->count() : 3 }},
                startX: 0,
                endX: 0,
                isDragging: false,
                timer: null,
                init() {
                    this.startAutoPlay();
                },
                startAutoPlay() {
                    this.timer = setInterval(() => {
                        this.nextSlide();
                    }, 5000);
                },
                resetAutoPlay() {
                    clearInterval(this.timer);
                    this.startAutoPlay();
                },
                nextSlide() {
                    this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                },
                prevSlide() {
                    this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
                },
                handleTouchStart(e) {
                    this.startX = e.touches[0].clientX;
                },
                handleTouchEnd(e) {
                    this.endX = e.changedTouches[0].clientX;
                    this.handleSwipe();
                },
                handleMouseDown(e) {
                    this.isDragging = true;
                    this.startX = e.clientX;
                },
                handleMouseUp(e) {
                    if (!this.isDragging) return;
                    this.isDragging = false;
                    this.endX = e.clientX;
                    this.handleSwipe();
                },
                handleSwipe() {
                    const diff = this.startX - this.endX;
                    const threshold = 40;
                    if (diff > threshold) {
                        this.nextSlide();
                        this.resetAutoPlay();
                    } else if (diff < -threshold) {
                        this.prevSlide();
                        this.resetAutoPlay();
                    }
                }
             }"
             @touchstart="handleTouchStart($event)"
             @touchend="handleTouchEnd($event)"
             @mousedown="handleMouseDown($event)"
             @mouseup="handleMouseUp($event)"
             @mouseleave="if(isDragging) { isDragging = false; }">

        <div class="relative h-[500px] sm:h-[600px] lg:h-[680px] w-full overflow-hidden">
            @if($banners->count() > 0)
                @foreach($banners as $index => $banner)
                    <div x-show="activeSlide === {{ $index }}" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 scale-105"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-700"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 pointer-events-none">
                        <img src="{{ asset('storage/' . $banner->image) }}" class="w-full h-full object-cover object-center" alt="{{ $banner->title }}">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/55 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl text-white pointer-events-auto">
                                    <span class="inline-block bg-emerald-500 text-neutral-950 font-black text-xs px-3.5 py-1.5 rounded-full uppercase tracking-wider mb-4 shadow-lg shadow-emerald-500/20">
                                        Rango Tour Special
                                    </span>
                                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black leading-tight tracking-tight mb-4">
                                        {{ $banner->title }}
                                    </h1>
                                    <p class="text-neutral-300 text-sm sm:text-lg mb-8 leading-relaxed">
                                        {{ $banner->subtitle ?? 'Experience handcrafted luxury itineraries across Thailand\'s top natural wonders.' }}
                                    </p>
                                    <a href="{{ $banner->button_link ?? route('tours.index') }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black uppercase text-xs tracking-wider px-8 py-4 rounded-xl shadow-xl shadow-emerald-500/20 hover:scale-105 transition duration-200">
                                        {{ $banner->button_text ?? 'Explore Now' }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div x-show="activeSlide === 0" class="absolute inset-0 pointer-events-none">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover" alt="Slide 1">
                    <div class="absolute inset-0 bg-black/60"></div>
                </div>
            @endif
        </div>

        <!-- Slider Dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
            <template x-for="i in totalSlides">
                <button @click="activeSlide = i - 1; resetAutoPlay()" 
                        :class="activeSlide === (i - 1) ? 'w-8 bg-emerald-400' : 'w-2 bg-neutral-700 hover:bg-neutral-500'" 
                        class="h-2 rounded-full transition-all duration-300"></button>
            </template>
        </div>
    </section>


    <!-- =========================================================================
         2. WELCOME TO KHAO SOK TOUR (Lake Resorts & Floating Bungalow 10-Slide Sliders)
         ========================================================================= -->
    <section class="bg-black text-white py-20 border-b border-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black uppercase tracking-tight text-white">
                    WELCOME TO KHAO SOK TOUR
                </h2>
                <p class="text-sm sm:text-base text-emerald-400/90 font-medium tracking-wide mt-2">
                    Floating Bungalows on Cheow Lan Lake &amp; Premier Resorts (Click photo to preview 10-slide gallery)
                </p>
            </div>

            @if(isset($resorts) && $resorts->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-20">
                    @foreach($resorts as $resort)
                        @php
                            // รวบรวมรูปภาพจริง: รูปปกหลัก + ภาพทั้งหมดใน Gallery
                            $resortGallery = [];
                            if (!empty($resort->image)) {
                                $resortGallery[] = asset('storage/' . $resort->image);
                            }
                            if (!empty($resort->gallery) && is_array($resort->gallery)) {
                                foreach($resort->gallery as $gImg) {
                                    $resortGallery[] = asset('storage/' . $gImg);
                                }
                            }
                        @endphp

                        <div @click="openGallery({{ json_encode($resortGallery) }}, '{{ addslashes($resort->name) }}')"
                             class="group relative rounded-2xl overflow-hidden aspect-[3/4] bg-neutral-900 shadow-xl border border-neutral-800 hover:border-emerald-500/70 transition-all duration-500 cursor-pointer hover:-translate-y-1">
                            <img src="{{ asset('storage/' . $resort->image) }}" alt="{{ $resort->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-85">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/25 to-black/60"></div>
                            
                            <!-- Gallery Slide Indicator Badge -->
                            <div class="absolute bottom-3 right-3 z-10 px-2 py-1 rounded-lg bg-black/80 backdrop-blur-md border border-neutral-700 text-[10px] font-mono-code text-emerald-300 flex items-center gap-1 group-hover:border-emerald-400">
                                <span>📸 {{ count($resortGallery) > 0 ? count($resortGallery) : 10 }} Photos</span>
                            </div>

                            <div class="absolute top-4 inset-x-3 text-center">
                                @if($resort->prefix)
                                    <span class="text-[9px] sm:text-[11px] tracking-widest uppercase font-semibold text-neutral-300 block">
                                        {{ $resort->prefix }}
                                    </span>
                                @endif
                                <h3 class="text-xs sm:text-sm md:text-base font-black tracking-wider uppercase text-white mt-0.5 group-hover:text-emerald-400 transition">
                                    {{ $resort->name }}
                                </h3>
                                @if($resort->subtitle)
                                    <span class="text-[8px] sm:text-[10px] tracking-widest text-emerald-400 uppercase block mt-0.5">
                                        {{ $resort->subtitle }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif


            <!-- =========================================================================
                 3. FULL-BOARD PACKAGES
                 ========================================================================= -->
            <div class="max-w-4xl mx-auto text-center space-y-4 mb-14">
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white leading-tight">
                    Embark on the Ultimate Adventure with Our Rango Tour Full-Board Package
                </h3>
                <p class="text-xs sm:text-sm text-neutral-300 leading-relaxed max-w-3xl mx-auto">
                    Discover the beauty of pristine national parks with our expert-guided tours. Stay in Floating Bungalows or 
                    <strong class="text-emerald-400 font-bold">luxurious floating resorts</strong> with guided trekking, wildlife spotting, and kayaking.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($featuredTours as $tour)
                    <a href="{{ route('tours.show', $tour->slug) }}" 
                       class="group relative rounded-3xl overflow-hidden h-[450px] bg-neutral-900 border border-neutral-800 shadow-2xl block hover:border-emerald-500/60 hover:shadow-emerald-500/10 transition duration-500">
                        <img src="{{ asset('storage/' . $tour->cover_image) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-75">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/45 to-black/60"></div>
                        
                        <div class="absolute inset-0 p-6 flex flex-col justify-between text-center">
                            <span class="text-xs uppercase tracking-widest font-bold text-emerald-400 font-mono-code">
                                {{ $tour->duration_days }} Days {{ $tour->duration_nights }} Nights
                            </span>

                            <div>
                                <h4 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight leading-snug group-hover:text-emerald-400 transition mb-2">
                                    {{ $tour->title }}
                                </h4>
                                <span class="text-emerald-400 font-black font-mono-code text-lg">
                                    ฿{{ number_format($tour->price) }} <span class="text-xs text-neutral-400 font-normal">/ person</span>
                                </span>
                            </div>

                            <div class="text-xs text-neutral-400 space-y-1">
                                <p class="line-clamp-2">{{ $tour->description }}</p>
                                <p class="text-emerald-400 font-bold font-mono-code pt-2">📍 {{ $tour->location }} &bull; Book Now &rarr;</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-12 border border-dashed border-neutral-800 rounded-3xl">
                        <p class="text-neutral-400 text-xs font-mono-code">No featured tour packages selected.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- =========================================================================
         4. BEST TOURS
         ========================================================================= -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-emerald-400 font-bold text-xs uppercase tracking-widest bg-emerald-950 px-3.5 py-1.5 rounded-md border border-emerald-800/80">
                    Handcrafted Itineraries
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-3 uppercase tracking-tight">
                    BEST TOURS
                </h2>
            </div>
            <a href="{{ route('destinations') }}" class="text-xs font-mono-code text-neutral-400 hover:text-emerald-400 flex items-center gap-1.5 transition mt-2 md:mt-0">
                <span>View All Best Tours</span>
                <span>➔</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($destinations->take(3) as $dest)
                <a href="{{ route('destinations') }}" 
                   class="bg-neutral-900 rounded-3xl overflow-hidden border border-neutral-800 shadow-xl group hover:border-emerald-500/50 transition duration-300 block hover:-translate-y-1">
                    <div class="relative h-72 overflow-hidden bg-neutral-950">
                        <img src="{{ asset('storage/' . $dest->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90" alt="{{ $dest->name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 bg-emerald-600 text-neutral-950 text-[11px] font-black uppercase px-3 py-1 rounded-full shadow">
                            {{ $dest->country ?? 'Thailand' }}
                        </span>
                        <div class="absolute bottom-4 right-4 bg-black/80 backdrop-blur-md px-3 py-1 rounded-xl border border-neutral-700 text-[10px] font-mono-code text-emerald-400 opacity-0 group-hover:opacity-100 transition">
                            Explore Best Tour ➔
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-white group-hover:text-emerald-400 transition">{{ $dest->name }}</h3>
                        <p class="text-neutral-400 text-xs mt-2 line-clamp-3 leading-relaxed">{{ $dest->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>


    <!-- =========================================================================
         5. GOOGLE MAPS & LOCATION
         ========================================================================= -->
    <section class="py-20 bg-neutral-950 border-t border-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-emerald-400 font-bold text-xs uppercase tracking-widest bg-emerald-950 px-3.5 py-1.5 rounded-md border border-emerald-800">
                    📍 Location &amp; Meeting Point
                </span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black uppercase text-white tracking-tight mt-3">
                    Ratchaprapha Dam &amp; Lake
                </h2>
                <p class="text-neutral-400 text-xs sm:text-sm mt-2">
                    Ratchaprapha Dam (Guilin of Thailand) • Cheow Lan Lake, Surat Thani, Thailand
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <div class="lg:col-span-5 bg-neutral-900 p-6 sm:p-8 rounded-3xl border border-neutral-800 shadow-2xl flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg">
                                🚤
                            </span>
                            <div>
                                <h3 class="font-bold text-white text-base">Cheow Lan Lake Tourist Pier</h3>
                                <p class="text-xs text-neutral-400">Main departure pier for longtail boats &amp; raft houses</p>
                            </div>
                        </div>

                        <p class="text-neutral-300 text-xs leading-relaxed">
                            <strong>Ratchaprapha Dam (Cheow Lan Lake)</strong>, famously known as the <em>"Guilin of Thailand"</em>, is situated within Khao Sok National Park, Surat Thani. Characterized by dramatic towering limestone karsts rising above emerald-green waters.
                        </p>
                    </div>

                    <div class="pt-4 border-t border-neutral-800">
                        <a href="https://maps.google.com/?q=Ratchaprapha+Dam+Surat+Thani" target="_blank" rel="noopener noreferrer" 
                           class="w-full inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black uppercase text-xs tracking-wider py-3.5 px-5 rounded-xl shadow-lg transition">
                            <span>🗺️ Open Navigation in Google Maps</span> ↗
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-7 bg-neutral-900 rounded-3xl overflow-hidden border border-neutral-800 shadow-2xl min-h-[380px] lg:min-h-[460px] relative">
                    <iframe 
                        src="https://maps.google.com/maps?q=Ratchaprapha%20Dam,%20Khao%20Phang,%20Ban%20Ta%20Khun%20District,%20Surat%20Thani&t=&z=12&ie=UTF8&iwloc=&output=embed" 
                        class="w-full h-full min-h-[380px] lg:min-h-[460px] border-0" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         6. ATMOSPHERE FEATURE HIGHLIGHTS
         ========================================================================= -->
    <section class="py-14 bg-neutral-900 text-white border-y border-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-4">
                <div class="text-3xl mb-2 text-emerald-400">🌿</div>
                <h4 class="font-bold text-base text-white">Pure Nature &amp; Serenity</h4>
                <p class="text-xs text-neutral-400 mt-1">Carefully planned routes avoiding crowded tourist traps.</p>
            </div>
            <div class="p-4">
                <div class="text-3xl mb-2 text-emerald-400">🛡️</div>
                <h4 class="font-bold text-base text-white">Certified Guides &amp; Safety</h4>
                <p class="text-xs text-neutral-400 mt-1">Licensed English-speaking experts on every route.</p>
            </div>
            <div class="p-4">
                <div class="text-3xl mb-2 text-emerald-400">💬</div>
                <h4 class="font-bold text-base text-white">Instant Chat Booking</h4>
                <p class="text-xs text-neutral-400 mt-1">Direct support via official LINE, WhatsApp, and In-Web Live Chat 24/7.</p>
            </div>
        </div>
    </section>

</div>

<!-- Alpine Script Engine: รองรับการเปิดภาพ Gallery จริงที่อัปโหลดไว้ -->
<script>
    function homepageManager() {
        return {
            showVideoModal: false,
            dontShowAgain: false,

            // Gallery Lightbox State
            galleryModal: false,
            galleryIndex: 0,
            activeGalleryTitle: '',
            galleryImages: [],

            init() {
                const isDismissed = localStorage.getItem('rango_hide_welcome_video') === 'true';
                if (!isDismissed) {
                    setTimeout(() => {
                        this.showVideoModal = true;
                        this.$nextTick(() => {
                            const video = document.getElementById('rangoWelcomeVideo');
                            if (video) {
                                video.muted = true;
                                video.play().catch(e => console.log('Autoplay handled:', e));
                            }
                        });
                    }, 400);
                }
            },

            closeVideoModal() {
                const videoEl = document.getElementById('rangoWelcomeVideo');
                if (videoEl) {
                    videoEl.pause();
                }

                if (this.dontShowAgain) {
                    localStorage.setItem('rango_hide_welcome_video', 'true');
                }

                this.showVideoModal = false;
            },

            // เปิด Lightbox Slide โดยรับ Array รูปภาพจริงจากฐานข้อมูล
            openGallery(images, title) {
                this.activeGalleryTitle = title;
                this.galleryIndex = 0;

                // ตรวจสอบว่ามีภาพจริงถูกส่งเข้ามาหรือไม่
                if (Array.isArray(images) && images.length > 0) {
                    this.galleryImages = images;
                } else if (typeof images === 'string' && images.trim() !== '') {
                    // หากส่งมาเป็น URL สตริงตัวเดียว ให้ใช้รูปนั้นเป็นรูปแรก และเสริมรูปบรรยากาศเขาสก
                    this.galleryImages = [
                        images,
                        'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1512100356356-de1b84283e18?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=85'
                    ];
                } else {
                    this.galleryImages = [
                        'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=85',
                        'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&w=1200&q=85'
                    ];
                }

                this.galleryModal = true;
            },

            closeGallery() {
                this.galleryModal = false;
            },

            nextGallery() {
                this.galleryIndex = (this.galleryIndex + 1) % this.galleryImages.length;
            },

            prevGallery() {
                this.galleryIndex = (this.galleryIndex - 1 + this.galleryImages.length) % this.galleryImages.length;
            }
        }
    }
</script>
@endsection