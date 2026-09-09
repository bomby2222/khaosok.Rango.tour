<!DOCTYPE html>
<html lang="en" class="scroll-smooth bg-neutral-950 text-neutral-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Khao Sok Rango Tour - Luxury Lake & Wildlife Experiences')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono-code { font-family: 'JetBrains Mono', monospace; }
        [x-cloak] { display: none !important; }
        .emerald-glow { box-shadow: 0 0 35px -5px rgba(16, 185, 129, 0.4); }
    </style>
</head>
<body class="bg-neutral-950 text-neutral-200 flex flex-col min-h-screen selection:bg-emerald-500 selection:text-neutral-950" x-data="{ mobileMenu: false }">

    <!-- Header / Navbar -->
    <header class="bg-black/90 backdrop-blur-md shadow-2xl sticky top-0 z-40 border-b border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Brand Logo: Khao Sok Rango Tour -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="text-xl sm:text-2xl font-black tracking-tight text-emerald-400 group-hover:text-emerald-300 transition">KHAO SOK RANGO</span>
                <span class="text-lg sm:text-xl font-black text-white tracking-widest">TOUR</span>
            </a>
            
            <!-- Desktop Nav Menu -->
            <nav class="hidden md:flex items-center gap-7 font-semibold text-xs tracking-wider uppercase">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-emerald-400 font-bold' : 'text-neutral-400 hover:text-emerald-400' }} transition">Home</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-emerald-400 font-bold' : 'text-neutral-400 hover:text-emerald-400' }} transition">About Us</a>
                <a href="{{ route('route.map') }}" class="{{ request()->routeIs('route.map') ? 'text-emerald-400 font-bold' : 'text-neutral-400 hover:text-emerald-400' }} transition">Route Map</a>
                <a href="{{ route('destinations') }}" class="{{ request()->routeIs('destinations') ? 'text-emerald-400 font-bold' : 'text-neutral-400 hover:text-emerald-400' }} transition">Best Tours</a>
                <a href="{{ route('tours.index') }}" class="{{ request()->routeIs('tours.*') ? 'text-emerald-400 font-bold' : 'text-neutral-400 hover:text-emerald-400' }} transition">Tour Packages</a>
                <a href="{{ route('reviews.index') }}" class="{{ request()->routeIs('reviews.*') ? 'text-emerald-400 font-bold' : 'text-neutral-400 hover:text-emerald-400' }} transition">Reviews</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-emerald-400 font-bold' : 'text-neutral-400 hover:text-emerald-400' }} transition">Contact</a>
            </nav>

            <!-- Desktop Taxi & Transfers Dropdown (เปลี่ยนแทนที่ปุ่ม Explore Tours เดิม) -->
            <div class="hidden md:flex items-center gap-3 relative" x-data="{ taxiMenu: false }">
                <button @click="taxiMenu = !taxiMenu" 
                        @click.away="taxiMenu = false"
                        type="button" 
                        class="bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 text-xs font-black uppercase tracking-wider px-5 py-2.5 rounded-full shadow-lg shadow-emerald-500/25 hover:scale-105 transition duration-200 flex items-center gap-2">
                    <span>🚕</span>
                    <span>TAXI &amp; TRANSFERS</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="taxiMenu ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <!-- Dropdown เมนู 4 โซนปลายทางหลัก -->
                <div x-show="taxiMenu" 
                     x-cloak 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute right-0 top-full mt-2 w-64 bg-neutral-900/98 backdrop-blur-xl border border-emerald-500/30 rounded-2xl shadow-2xl p-2 z-50 space-y-1 font-mono-code text-xs">
                    
                    <div class="px-3 py-1.5 text-[10px] uppercase font-bold text-zinc-500 border-b border-zinc-800">// 4 DESTINATION ZONES</div>

                    <a href="{{ route('taxi.transfers', ['zone' => 'phuket']) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-zinc-300 hover:text-white hover:bg-emerald-500/20 transition">
                        <span class="flex items-center gap-2"><span>🏝️</span> เที่ยวรถภูเก็ต (Phuket)</span>
                        <span class="text-[10px] text-emerald-400">&rarr;</span>
                    </a>
                    <a href="{{ route('taxi.transfers', ['zone' => 'khaosok']) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-zinc-300 hover:text-white hover:bg-emerald-500/20 transition">
                        <span class="flex items-center gap-2"><span>🛶</span> เที่ยวรถเขาสก (Khao Sok)</span>
                        <span class="text-[10px] text-emerald-400">&rarr;</span>
                    </a>
                    <a href="{{ route('taxi.transfers', ['zone' => 'phangnga']) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-zinc-300 hover:text-white hover:bg-emerald-500/20 transition">
                        <span class="flex items-center gap-2"><span>⛰️</span> เที่ยวรถพังงา (Phang Nga)</span>
                        <span class="text-[10px] text-emerald-400">&rarr;</span>
                    </a>
                    <a href="{{ route('taxi.transfers', ['zone' => 'krabi']) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-zinc-300 hover:text-white hover:bg-emerald-500/20 transition">
                        <span class="flex items-center gap-2"><span>🏖️</span> เที่ยวรถกระบี่ (Krabi)</span>
                        <span class="text-[10px] text-emerald-400">&rarr;</span>
                    </a>

                    <div class="pt-1 border-t border-zinc-800">
                        <a href="{{ route('taxi.transfers') }}" class="block text-center py-2 text-[11px] font-bold text-emerald-400 hover:underline">
                            ดูเที่ยวรถทั้งหมด &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile Hamburger Button -->
            <button @click="mobileMenu = !mobileMenu" class="md:hidden text-neutral-300 hover:text-white focus:outline-none p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" x-cloak class="md:hidden bg-neutral-900 border-b border-neutral-800 px-6 py-5 space-y-4 font-semibold text-xs uppercase tracking-wider">
            <a href="{{ route('home') }}" class="block {{ request()->routeIs('home') ? 'text-emerald-400' : 'text-neutral-400' }}">Home</a>
            <a href="{{ route('about') }}" class="block {{ request()->routeIs('about') ? 'text-emerald-400' : 'text-neutral-400' }}">About Us</a>
            <a href="{{ route('route.map') }}" class="block {{ request()->routeIs('route.map') ? 'text-emerald-400' : 'text-neutral-400' }}">Route Map</a>
            <a href="{{ route('destinations') }}" class="block {{ request()->routeIs('destinations') ? 'text-emerald-400' : 'text-neutral-400' }}">Best Tours</a>
            <a href="{{ route('tours.index') }}" class="block {{ request()->routeIs('tours.*') ? 'text-emerald-400' : 'text-neutral-400' }}">Tour Packages</a>
            <a href="{{ route('reviews.index') }}" class="block {{ request()->routeIs('reviews.*') ? 'text-emerald-400' : 'text-neutral-400' }}">Reviews</a>
            <a href="{{ route('contact') }}" class="block {{ request()->routeIs('contact') ? 'text-emerald-400' : 'text-neutral-400' }}">Contact</a>
            
            <!-- Mobile Taxi Section with 4 Zones -->
            <div class="pt-3 border-t border-neutral-800 space-y-2">
                <a href="{{ route('taxi.transfers') }}" class="block text-emerald-400 font-bold">🚕 Taxi &amp; Transfers (รถรับส่ง)</a>
                <div class="grid grid-cols-2 gap-2 text-[11px] font-mono-code normal-case pl-2">
                    <a href="{{ route('taxi.transfers', ['zone' => 'phuket']) }}" class="text-neutral-400 hover:text-white">🏝️ ภูเก็ต</a>
                    <a href="{{ route('taxi.transfers', ['zone' => 'khaosok']) }}" class="text-neutral-400 hover:text-white">🛶 เขาสก</a>
                    <a href="{{ route('taxi.transfers', ['zone' => 'phangnga']) }}" class="text-neutral-400 hover:text-white">⛰️ พังงา</a>
                    <a href="{{ route('taxi.transfers', ['zone' => 'krabi']) }}" class="text-neutral-400 hover:text-white">🏖️ กระบี่</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black text-neutral-400 py-14 mt-24 border-t border-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xl sm:text-2xl font-black tracking-tight text-emerald-400">KHAO SOK RANGO</span>
                        <span class="text-lg sm:text-xl font-black text-white tracking-widest">TOUR</span>
                    </div>
                    <p class="text-xs text-neutral-400 leading-relaxed max-w-sm">
                        Premier Khao Sok rainforest tours, luxury floating bungalows on Cheow Lan Lake, private cross-province taxi transfers, certified local guides, and instant direct booking support.
                    </p>
                </div>
                <div>
                    <h4 class="text-white text-xs uppercase font-bold tracking-widest mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-emerald-400 transition">About Us</a></li>
                        <li><a href="{{ route('route.map') }}" class="hover:text-emerald-400 transition">Route Map</a></li>
                        <li><a href="{{ route('destinations') }}" class="hover:text-emerald-400 transition">Best Tours</a></li>
                        <li><a href="{{ route('tours.index') }}" class="hover:text-emerald-400 transition">Tour Packages</a></li>
                        <li><a href="{{ route('taxi.transfers') }}" class="text-emerald-400 hover:underline transition">Taxi &amp; Transfers</a></li>
                        <li><a href="{{ route('reviews.index') }}" class="hover:text-emerald-400 transition">Reviews</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-emerald-400 transition">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs uppercase font-bold tracking-widest mb-4">Direct Channels</h4>
                    <ul class="space-y-2 text-xs">
                        <li>WhatsApp: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '66812345678') }}" target="_blank" class="text-emerald-400 font-semibold hover:underline">+{{ $settings['whatsapp_number'] ?? '66 81 234 5678' }}</a></li>
                        <li>Email: <a href="mailto:{{ $settings['contact_email'] ?? $settings['email'] ?? 'booking@khaosokrangotour.com' }}" class="text-amber-400 font-semibold hover:underline">{{ $settings['contact_email'] ?? $settings['email'] ?? 'booking@khaosokrangotour.com' }}</a></li>
                        <li>Instagram: <a href="{{ $settings['instagram_url'] ?? 'https://instagram.com/khaosokrangotour' }}" target="_blank" class="text-pink-400 font-semibold hover:underline">{{ $settings['instagram_handle'] ?? '@khaosokrangotour' }}</a></li>
                        <li>Facebook: <a href="{{ $settings['facebook_url'] ?? 'https://facebook.com/khaosokrangotour' }}" target="_blank" class="text-blue-400 font-semibold hover:underline">{{ $settings['facebook_name'] ?? 'Khao Sok Rango Tour' }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-neutral-900 pt-8 text-center text-xs text-neutral-500">
                &copy; 2026 Khao Sok Rango Tour Co., Ltd. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- =========================================================================
         ALL-IN-ONE FLOATING CHAT HUB (WhatsApp, Instagram, Facebook + Live Chat)
         ========================================================================= -->
    <div x-data="rangoFloatingChat()" x-cloak class="fixed bottom-6 right-6 z-50">
        
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-6 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-6 scale-95"
             class="bg-neutral-900/98 backdrop-blur-2xl border border-emerald-500/30 rounded-3xl w-[340px] sm:w-[390px] shadow-2xl overflow-hidden mb-4">
            
            <!-- Header Bar -->
            <div class="bg-black/90 p-4 border-b border-neutral-800 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-sm">
                        💬
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-xs font-black text-white uppercase tracking-wider">KHAO SOK SUPPORT</h4>
                            <template x-if="hasRegistered">
                                <button type="button" @click="isEditingName = !isEditingName" class="text-[10px] text-emerald-400 hover:text-emerald-300 underline font-mono-code">
                                    [✏️ Rename]
                                </button>
                            </template>
                        </div>
                        <template x-if="hasRegistered">
                            <span class="text-[10px] font-mono-code text-zinc-400 block" x-text="'User: ' + guestName"></span>
                        </template>
                        <template x-if="!hasRegistered">
                            <span class="text-[10px] font-mono-code text-emerald-400">● Live Chat Online</span>
                        </template>
                    </div>
                </div>
                <button @click="isOpen = false" class="text-neutral-400 hover:text-white p-1 text-sm font-mono-code">✕</button>
            </div>

            <!-- Inline Name Editor -->
            <div x-show="isEditingName" x-transition class="p-3 bg-neutral-950 border-b border-neutral-800">
                <form @submit.prevent="updateName()" class="flex items-center gap-2">
                    <input type="text" x-model="tempName" required placeholder="Enter new display name..." 
                           class="flex-grow bg-neutral-900 text-white text-xs px-3 py-2 rounded-xl border border-neutral-700 focus:outline-none focus:border-emerald-500">
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-black font-bold px-3 py-2 rounded-xl text-xs">
                        Save
                    </button>
                    <button type="button" @click="isEditingName = false" class="text-neutral-400 text-xs px-1">
                        Cancel
                    </button>
                </form>
            </div>

            <!-- 3 Social & Messaging Shortcuts (WhatsApp, Instagram, Facebook) -->
            <div class="grid grid-cols-3 gap-2 p-3 bg-neutral-950/90 border-b border-neutral-800 text-[10px] font-bold">
                <!-- WhatsApp -->
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '66812345678') }}" target="_blank" 
                   class="bg-[#25D366]/15 hover:bg-[#25D366] text-[#25D366] hover:text-white border border-[#25D366]/30 py-2 rounded-xl flex flex-col items-center justify-center gap-1 transition group">
                    <svg class="w-4 h-4 fill-current group-hover:scale-110 transition" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>WhatsApp</span>
                </a>

                <!-- Instagram -->
                <a href="{{ $settings['instagram_url'] ?? 'https://instagram.com/khaosokrangotour' }}" target="_blank" 
                   class="bg-[#E1306C]/15 hover:bg-[#E1306C] text-[#E1306C] hover:text-white border border-[#E1306C]/30 py-2 rounded-xl flex flex-col items-center justify-center gap-1 transition group">
                    <svg class="w-4 h-4 fill-current group-hover:scale-110 transition" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    <span>Instagram</span>
                </a>

                <!-- Facebook -->
                <a href="{{ $settings['facebook_url'] ?? 'https://facebook.com/khaosokrangotour' }}" target="_blank" 
                   class="bg-[#1877F2]/15 hover:bg-[#1877F2] text-[#1877F2] hover:text-white border border-[#1877F2]/30 py-2 rounded-xl flex flex-col items-center justify-center gap-1 transition group">
                    <svg class="w-4 h-4 fill-current group-hover:scale-110 transition" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    <span>Facebook</span>
                </a>
            </div>

            <!-- STEP 1: Registration Form -->
            <div x-show="!hasRegistered" class="p-6 text-center space-y-4 bg-[#090b0d]">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 mx-auto flex items-center justify-center text-2xl shadow-lg">
                    👋
                </div>
                <div>
                    <h5 class="text-sm font-black text-white">Welcome to Khao Sok Rango Tour</h5>
                    <p class="text-xs text-neutral-400 mt-1">Please enter your name to start the live chat.</p>
                </div>

                <form @submit.prevent="registerName()" class="space-y-3 pt-2">
                    <input type="text" x-model="inputName" required placeholder="Your name (e.g. John Doe)..." 
                           class="w-full bg-black text-white placeholder-neutral-500 border border-neutral-700 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-black font-black uppercase text-xs tracking-wider py-3.5 rounded-xl shadow-lg transition">
                        Start Live Chat
                    </button>
                </form>
            </div>

            <!-- STEP 2: Live Chat Messages Box -->
            <div x-show="hasRegistered">
                <div id="liveChatMessagesBox" class="h-64 sm:h-72 overflow-y-auto p-4 space-y-3 text-xs bg-[#090b0d]">
                    <template x-for="msg in messages" :key="msg.id">
                        <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex items-start gap-2.5'">
                            <template x-if="msg.sender === 'admin'">
                                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0">R</div>
                            </template>
                            <div :class="msg.sender === 'user' ? 'bg-emerald-600 text-neutral-950 font-semibold rounded-br-sm' : 'bg-neutral-800 text-neutral-200 rounded-tl-sm'"
                                 class="p-3 rounded-2xl max-w-[85%] leading-relaxed shadow-sm">
                                <p class="whitespace-pre-line" x-text="msg.message"></p>
                                <span :class="msg.sender === 'user' ? 'text-neutral-900/70' : 'text-neutral-500'" class="text-[9px] font-mono-code block text-right mt-1" x-text="msg.time"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Input Message Box -->
                <form @submit.prevent="sendMessage()" class="p-3 bg-neutral-950 border-t border-neutral-800 flex items-center gap-2">
                    <input type="text" x-model="newMessage" placeholder="Type your message..." required
                           class="flex-grow bg-neutral-900 text-white placeholder-neutral-500 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black p-2.5 rounded-xl transition shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Floating Trigger Button -->
        <button @click="isOpen = !isOpen" 
                class="relative bg-gradient-to-tr from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black p-4 rounded-full shadow-2xl shadow-emerald-500/40 hover:scale-110 active:scale-95 transition-all duration-300 flex items-center justify-center">
            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500 border-2 border-black"></span>
            </span>

            <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <svg x-show="isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Frontend Live Chat JavaScript Engine -->
    <script>
        function rangoFloatingChat() {
            return {
                isOpen: false,
                hasRegistered: false,
                guestName: '',
                inputName: '',
                tempName: '',
                isEditingName: false,
                sessionId: '',
                messages: [],
                newMessage: '',
                pendingMessage: '',
                pollingTimer: null,

                init() {
                    if (!localStorage.getItem('rango_chat_session')) {
                        localStorage.setItem('rango_chat_session', 'guest_' + Math.random().toString(36).substring(2, 9) + Date.now());
                    }
                    this.sessionId = localStorage.getItem('rango_chat_session');

                    const savedName = localStorage.getItem('rango_chat_name');
                    if (savedName) {
                        this.guestName = savedName;
                        this.hasRegistered = true;
                    }

                    this.fetchChat();

                    window.addEventListener('open-rango-chat', (e) => {
                        this.isOpen = true;
                        const msg = e.detail ? e.detail.message : '';
                        if (msg) {
                            if (this.hasRegistered) {
                                this.sendDirectMessage(msg);
                            } else {
                                this.pendingMessage = msg;
                            }
                        }
                    });

                    this.pollingTimer = setInterval(() => {
                        if (this.isOpen && this.hasRegistered) {
                            this.fetchChat();
                        }
                    }, 3000);
                },

                registerName() {
                    if (!this.inputName.trim()) return;
                    this.guestName = this.inputName.trim();

                    fetch('/chat/init', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            session_id: this.sessionId,
                            guest_name: this.guestName
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localStorage.setItem('rango_chat_name', this.guestName);
                            this.hasRegistered = true;
                            this.fetchChat();

                            if (this.pendingMessage) {
                                setTimeout(() => {
                                    this.sendDirectMessage(this.pendingMessage);
                                    this.pendingMessage = '';
                                }, 500);
                            }
                        }
                    });
                },

                updateName() {
                    if (!this.tempName.trim()) return;
                    const newName = this.tempName.trim();

                    fetch('/chat/rename', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            session_id: this.sessionId,
                            guest_name: newName
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.guestName = newName;
                            localStorage.setItem('rango_chat_name', newName);
                            this.isEditingName = false;
                            this.tempName = '';
                        }
                    });
                },

                fetchChat() {
                    fetch(`/chat/messages?session_id=${this.sessionId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.guest_name && !this.guestName) {
                                this.guestName = data.guest_name;
                                this.hasRegistered = true;
                                localStorage.setItem('rango_chat_name', data.guest_name);
                            }
                            if (data.messages && data.messages.length !== this.messages.length) {
                                this.messages = data.messages;
                                this.scrollToBottom();
                            }
                        })
                        .catch(err => console.error(err));
                },

                sendDirectMessage(text) {
                    fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            session_id: this.sessionId,
                            message: text
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.messages.push(data.message);
                            this.scrollToBottom();
                        }
                    });
                },

                sendMessage() {
                    if (!this.newMessage.trim()) return;
                    const text = this.newMessage;
                    this.newMessage = '';
                    this.sendDirectMessage(text);
                },

                scrollToBottom() {
                    setTimeout(() => {
                        const box = document.getElementById('liveChatMessagesBox');
                        if (box) box.scrollTop = box.scrollHeight;
                    }, 100);
                }
            }
        }
    </script>
</body>
</html>ss