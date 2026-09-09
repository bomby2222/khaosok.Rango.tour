@extends('layouts.app')

@section('title', 'Contact & Direct Concierge - Khao Sok Rango Tour')

@section('content')
<div class="relative space-y-16 sm:space-y-24 overflow-hidden py-10">

    <!-- Ambient Glowing Gradient Orbs -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[750px] h-[400px] bg-emerald-500/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-teal-500/10 rounded-full blur-[160px] pointer-events-none -z-10"></div>

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-emerald-950/60 border border-emerald-500/30 backdrop-blur-xl shadow-xl">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span class="text-[10px] sm:text-xs font-mono-code font-bold uppercase tracking-[0.25em] text-emerald-300">
                Direct Communications &amp; Bookings
            </span>
        </div>
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-white uppercase tracking-tight">
            Contact &amp; Inquiries
        </h1>
        <p class="text-xs sm:text-sm md:text-base text-neutral-400 max-w-2xl mx-auto font-normal leading-relaxed">
            Reach out directly to our Khao Sok travel specialists via your preferred platform for custom expedition itineraries, boat charters, corporate bookings, and overwater bungalow allotments.
        </p>
    </div>

    <!-- 4-Channel Connect Grid (WhatsApp, Email, Instagram, Facebook) -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            
            <!-- 1. WhatsApp Support -->
            <div class="bg-neutral-900/60 backdrop-blur-xl p-7 sm:p-8 rounded-3xl border border-neutral-800 hover:border-[#25D366]/50 transition-all duration-300 shadow-2xl flex flex-col justify-between group hover:-translate-y-1">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 bg-[#25D366]/15 text-[#25D366] border border-[#25D366]/30 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300">
                            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </div>
                        <span class="text-[10px] font-mono-code text-teal-400 font-bold uppercase bg-teal-500/10 px-2.5 py-1 rounded-full border border-teal-500/20">24/7 Global</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-wide">WhatsApp Concierge</h3>
                        <p class="text-xs text-neutral-400 mt-1 leading-relaxed">Dedicated line for overseas travelers, cross-province airport pickups, and private charter inquiries.</p>
                    </div>
                    <div class="pt-2">
                        <span class="text-[10px] font-mono-code text-neutral-500 uppercase block">Direct WhatsApp Number</span>
                        <p class="text-sm font-black font-mono-code text-emerald-400 mt-0.5">+{{ $settings['whatsapp_number'] ?? '66812345678' }}</p>
                    </div>
                </div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '66812345678') }}" 
                   target="_blank" 
                   class="mt-6 w-full bg-[#25D366] hover:bg-[#20ba59] text-white font-black py-3.5 px-4 rounded-xl text-center text-xs uppercase tracking-wider shadow-lg shadow-[#25D366]/20 transition flex items-center justify-center gap-2">
                    <span>Open WhatsApp Chat</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- 2. Official Email Support -->
            <div class="bg-neutral-900/60 backdrop-blur-xl p-7 sm:p-8 rounded-3xl border border-neutral-800 hover:border-amber-500/50 transition-all duration-300 shadow-2xl flex flex-col justify-between group hover:-translate-y-1">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 bg-amber-500/15 text-amber-400 border border-amber-500/30 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-mono-code text-amber-400 font-bold uppercase bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/20">Formal Quotes</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-wide">Official Email</h3>
                        <p class="text-xs text-neutral-400 mt-1 leading-relaxed">For B2B agency partnerships, large group quotations, customized private itineraries, and invoice receipts.</p>
                    </div>
                    <div class="pt-2">
                        <span class="text-[10px] font-mono-code text-neutral-500 uppercase block">Direct Inquiries Inbox</span>
                        <p class="text-sm font-black font-mono-code text-amber-400 mt-0.5 truncate">{{ $settings['contact_email'] ?? $settings['email'] ?? 'booking@khaosokrangotour.com' }}</p>
                    </div>
                </div>
                <a href="mailto:{{ $settings['contact_email'] ?? $settings['email'] ?? 'booking@khaosokrangotour.com' }}?subject=Tour%20Inquiry%20-%20Khao%20Sok%20Rango%20Tour" 
                   class="mt-6 w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-neutral-950 font-black py-3.5 px-4 rounded-xl text-center text-xs uppercase tracking-wider shadow-lg shadow-amber-500/20 transition flex items-center justify-center gap-2">
                    <span>Send Email Directly</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- 3. Instagram -->
            <div class="bg-neutral-900/60 backdrop-blur-xl p-7 sm:p-8 rounded-3xl border border-neutral-800 hover:border-[#E1306C]/50 transition-all duration-300 shadow-2xl flex flex-col justify-between group hover:-translate-y-1">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 bg-gradient-to-tr from-[#fd5949]/20 via-[#d6249f]/20 to-[#285AEB]/20 text-[#E1306C] border border-[#E1306C]/30 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300">
                            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                        <span class="text-[10px] font-mono-code text-pink-400 font-bold uppercase bg-pink-500/10 px-2.5 py-1 rounded-full border border-pink-500/20">Photos &amp; Reels</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-wide">Instagram</h3>
                        <p class="text-xs text-neutral-400 mt-1 leading-relaxed">Discover expedition highlights, daily story updates from Cheow Lan Lake, and guest experiences.</p>
                    </div>
                    <div class="pt-2">
                        <span class="text-[10px] font-mono-code text-neutral-500 uppercase block">Follow Official Handle</span>
                        <p class="text-sm font-black font-mono-code text-emerald-400 mt-0.5">{{ $settings['instagram_handle'] ?? '@khaosokrangotour' }}</p>
                    </div>
                </div>
                <a href="{{ $settings['instagram_url'] ?? 'https://instagram.com/khaosokrangotour' }}" 
                   target="_blank" 
                   class="mt-6 w-full bg-gradient-to-r from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-90 text-white font-black py-3.5 px-4 rounded-xl text-center text-xs uppercase tracking-wider shadow-lg shadow-pink-500/20 transition flex items-center justify-center gap-2">
                    <span>Follow on Instagram</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- 4. Facebook Page -->
            <div class="bg-neutral-900/60 backdrop-blur-xl p-7 sm:p-8 rounded-3xl border border-neutral-800 hover:border-[#1877F2]/50 transition-all duration-300 shadow-2xl flex flex-col justify-between group hover:-translate-y-1">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 bg-[#1877F2]/15 text-[#1877F2] border border-[#1877F2]/30 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition duration-300">
                            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </div>
                        <span class="text-[10px] font-mono-code text-blue-400 font-bold uppercase bg-blue-500/10 px-2.5 py-1 rounded-full border border-blue-500/20">Official Page</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white uppercase tracking-wide">Facebook Page</h3>
                        <p class="text-xs text-neutral-400 mt-1 leading-relaxed">Stay updated with latest announcements, verified traveler reviews, and seasonal tour promotions.</p>
                    </div>
                    <div class="pt-2">
                        <span class="text-[10px] font-mono-code text-neutral-500 uppercase block">Facebook Community</span>
                        <p class="text-sm font-black font-mono-code text-emerald-400 mt-0.5">{{ $settings['facebook_name'] ?? 'Khao Sok Rango Tour' }}</p>
                    </div>
                </div>
                <a href="{{ $settings['facebook_url'] ?? 'https://facebook.com/khaosokrangotour' }}" 
                   target="_blank" 
                   class="mt-6 w-full bg-[#1877F2] hover:bg-[#166fe5] text-white font-black py-3.5 px-4 rounded-xl text-center text-xs uppercase tracking-wider shadow-lg shadow-[#1877F2]/20 transition flex items-center justify-center gap-2">
                    <span>Visit Facebook Page</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

        </div>
    </div>

    <!-- Quick Live Chat Assistant Bar -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="p-6 sm:p-8 rounded-3xl bg-black/70 backdrop-blur-2xl border border-neutral-800 text-center space-y-4 shadow-2xl">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-xl">
                💬
            </div>
            <div>
                <h3 class="text-lg font-black text-white uppercase">Need Immediate Booking Help?</h3>
                <p class="text-xs text-neutral-400 max-w-md mx-auto mt-1">Start a conversation right now with our concierge bot or wait for an available agent.</p>
            </div>
            <button type="button" 
                    @click="$dispatch('open-rango-chat', { message: 'Hello! I have a question regarding tour bookings.' })"
                    class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black uppercase text-xs tracking-wider shadow-lg shadow-emerald-500/25 transition duration-200">
                <span>Launch Live Chat Hub</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </div>

</div>
@endsection