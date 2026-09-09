@extends('layouts.app')

@section('title', 'About Us - ' . ($settings['about_header_title'] ?? 'Our Story & Legacy'))

@section('content')
<div class="min-h-screen bg-black text-white">

    <!-- Top Hero Banner -->
    <section class="relative bg-gradient-to-b from-emerald-950/80 via-emerald-950/30 to-black py-16 sm:py-24 border-b border-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black uppercase tracking-tight text-white">
                {{ $settings['about_header_title'] ?? 'Our Story & Legacy' }}
            </h1>
            <p class="text-xs sm:text-sm font-mono-code text-emerald-400 uppercase tracking-widest mt-3">
                Crafting Unforgettable Experiences Across Thailand's Wilderness
            </p>
        </div>
    </section>

    <!-- Main About Story Section -->
    <section class="py-16 sm:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 sm:gap-14 items-center">
            
            <!-- Left 6 Cols: Story Image with Floating Badge -->
            <div class="lg:col-span-6 relative">
                <div class="relative rounded-3xl sm:rounded-[2.5rem] overflow-hidden border border-neutral-800 shadow-2xl bg-neutral-900 aspect-[4/3] group">
                    @if(isset($settings['about_image']) && !empty($settings['about_image']))
                        <img src="{{ asset('storage/' . $settings['about_image']) }}" 
                             alt="{{ $settings['about_title'] ?? 'Rango Tour' }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    @else
                        <!-- Fallback Default Image -->
                        <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?auto=format&fit=crop&w=1000&q=80" 
                             alt="Rango Tour" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

                    <!-- Floating Badge at the Bottom of Image -->
                    <div class="absolute bottom-4 left-4 right-4 bg-neutral-950/90 backdrop-blur-md p-4 rounded-2xl border border-neutral-800 shadow-xl">
                        <span class="text-xs font-bold text-emerald-400 block">
                            {{ $settings['about_badge_title'] ?? 'Certified Local Operator' }}
                        </span>
                        <p class="text-[11px] text-neutral-300 mt-0.5 leading-relaxed font-sans">
                            {{ $settings['about_badge_desc'] ?? 'Dedicated team delivering verified tour programs throughout Thailand.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right 6 Cols: Story Content & Feature Cards -->
            <div class="lg:col-span-6 space-y-6">
                
                <!-- Badge Tag -->
                <div>
                    <span class="inline-block px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                        {{ $settings['about_badge'] ?? 'WHO WE ARE' }}
                    </span>
                </div>

                <!-- Main Story Title (แก้ปัญหาสีมืด ให้อ่านง่าย คมชัด) -->
                <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight tracking-tight">
                    {{ $settings['about_title'] ?? 'Passionate Travel Explorers with High Standards' }}
                </h2>

                <!-- Description Paragraph -->
                <p class="text-neutral-300 text-sm sm:text-base leading-relaxed">
                    {{ $settings['about_description'] ?? 'Rango Tour was founded to transform ordinary vacations into meaningful, stress-free adventures. We curate verified routes, partner with licensed local guides, and provide real-time availability with direct support.' }}
                </p>

                <!-- 2 Feature Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    
                    <!-- Card 1 (Direct Chat Booking) -->
                    <div class="bg-neutral-900/80 backdrop-blur p-5 rounded-2xl border border-emerald-500/30 shadow-lg space-y-1.5">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="text-emerald-400">💬</span> {{ $settings['about_card1_title'] ?? 'Direct Chat Booking' }}
                        </h4>
                        <p class="text-xs text-neutral-400 leading-relaxed font-sans">
                            {{ $settings['about_card1_desc'] ?? 'Instant confirmations through official LINE & WhatsApp.' }}
                        </p>
                    </div>

                    <!-- Card 2 (Handpicked Guides) -->
                    <div class="bg-neutral-900/80 backdrop-blur p-5 rounded-2xl border border-neutral-800 shadow-lg space-y-1.5">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="text-emerald-400">🛡️</span> {{ $settings['about_card2_title'] ?? 'Handpicked Guides' }}
                        </h4>
                        <p class="text-xs text-neutral-400 leading-relaxed font-sans">
                            {{ $settings['about_card2_desc'] ?? 'Safe, knowledgeable, and English-speaking tour guides.' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>

</div>
@endsection