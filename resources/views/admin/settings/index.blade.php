@extends('layouts.admin')

@section('title', 'SETTINGS & POPUP // RANGO ADMIN')
@section('header', 'SYSTEM SETTINGS & SOCIAL CHANNELS')

@section('content')
<div class="max-w-5xl mx-auto space-y-8" 
     x-data="{ 
        activeTab: 'popup',
        imagePreview: '{{ isset($settings['about_image']) ? asset('storage/' . $settings['about_image']) : '' }}',
        videoPreviewName: '',
        fileChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.imagePreview = URL.createObjectURL(file);
            }
        },
        videoChosen(event) {
            const file = event.target.files[0];
            if (file) {
                this.videoPreviewName = file.name + ' (' + (file.size / (1024*1024)).toFixed(2) + ' MB)';
            }
        }
     }">

    <!-- Top Tabs Switcher -->
    <div class="flex flex-wrap items-center gap-2 sm:gap-3 bg-black/60 p-1.5 rounded-2xl border border-zinc-800 w-fit">
        <button type="button" @click="activeTab = 'popup'" 
                :class="activeTab === 'popup' ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/20' : 'text-zinc-400 hover:text-white'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-xs font-mono-code uppercase tracking-wider transition">
            🎬 Video Popup Modal
        </button>
        <button type="button" @click="activeTab = 'about'" 
                :class="activeTab === 'about' ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/20' : 'text-zinc-400 hover:text-white'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-xs font-mono-code uppercase tracking-wider transition">
            📖 About Us Page
        </button>
        <button type="button" @click="activeTab = 'contact'" 
                :class="activeTab === 'contact' ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/20' : 'text-zinc-400 hover:text-white'"
                class="px-4 sm:px-5 py-2.5 rounded-xl text-xs font-mono-code uppercase tracking-wider transition">
            💬 Contacts &amp; Socials
        </button>
    </div>

    <!-- Main Form Container -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- =========================================================================
             TAB 1: HOMEPAGE VIDEO POPUP MODAL CONTROL
             ========================================================================= -->
        <div x-show="activeTab === 'popup'" x-transition class="space-y-6">
            <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-zinc-800">
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-500/20 text-emerald-400 font-mono-code font-bold text-xs flex items-center justify-center">01</span>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">Homepage Video Popup Settings</h3>
                    </div>
                    <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase">1-MINUTE POPUP BOX</span>
                </div>

                <!-- Enable/Disable Switch -->
                <div class="p-4 rounded-2xl bg-black/50 border border-zinc-800 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-white block uppercase">Enable Homepage Video Popup</span>
                        <span class="text-[11px] font-mono-code text-zinc-400">Display video modal popup centered on the screen when visitors open the homepage.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="popup_video_status" value="1" {{ ($settings['popup_video_status'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-12 gap-5">
                    <div class="sm:col-span-8">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Popup Headline Title</label>
                        <input type="text" name="popup_video_title" 
                               value="{{ $settings['popup_video_title'] ?? 'Discover Luxury Nature Adventures' }}" 
                               class="w-full bg-black/80 text-white border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none">
                    </div>

                    <div class="sm:col-span-4">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Badge / Tag</label>
                        <input type="text" name="popup_video_badge" 
                               value="{{ $settings['popup_video_badge'] ?? 'RANGO TOUR HIGHLIGHT' }}" 
                               class="w-full bg-black/80 text-emerald-400 font-bold border border-zinc-800 focus:border-emerald-500 rounded-2xl p-4 text-xs font-medium focus:outline-none">
                    </div>

                    <div class="sm:col-span-12">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Upload Video File (MP4, WebM - Max 50MB) *</label>
                        
                        <div class="relative rounded-2xl border-2 border-dashed border-zinc-800 hover:border-emerald-500/50 bg-black/50 p-6 text-center cursor-pointer overflow-hidden">
                            <input type="file" name="popup_video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime" @change="videoChosen" 
                                   class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10">

                            <div class="space-y-3 py-4">
                                <span class="text-3xl block">🎥</span>
                                <p class="text-xs font-bold text-white uppercase">Click or Drag &amp; Drop Video Here</p>
                                <p class="text-[11px] font-mono-code text-zinc-500">Supports standard 16:9 or square promotional clips</p>

                                <template x-if="videoPreviewName">
                                    <p class="text-xs font-mono-code text-emerald-400 font-bold mt-2" x-text="'Selected: ' + videoPreviewName"></p>
                                </template>
                            </div>
                        </div>

                        @if(isset($settings['popup_video_file']) && !empty($settings['popup_video_file']))
                            <div class="mt-4 p-4 rounded-2xl bg-black border border-zinc-800 space-y-2">
                                <span class="text-[10px] font-mono-code uppercase text-zinc-400 block">// Current Uploaded Video Preview</span>
                                <div class="max-w-md mx-auto aspect-video rounded-xl overflow-hidden border border-zinc-800 bg-neutral-950">
                                    <video controls class="w-full h-full object-cover">
                                        <source src="{{ asset('storage/' . $settings['popup_video_file']) }}" type="video/mp4">
                                        Your browser does not support HTML video.
                                    </video>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             TAB 2: ABOUT US PAGE CONTENT MANAGER
             ========================================================================= -->
        <div x-show="activeTab === 'about'" x-transition class="space-y-6">
            <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-5">
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Page Top Banner Title</label>
                        <input type="text" name="about_header_title" 
                               value="{{ $settings['about_header_title'] ?? 'Our Story & Legacy' }}" 
                               class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs">
                    </div>

                    <div class="sm:col-span-6">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Badge / Tag</label>
                        <input type="text" name="about_badge" 
                               value="{{ $settings['about_badge'] ?? 'WHO WE ARE' }}" 
                               class="w-full bg-black/80 text-emerald-400 font-bold border border-zinc-800 rounded-2xl p-4 text-xs">
                    </div>

                    <div class="sm:col-span-12">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Main Story Title</label>
                        <input type="text" name="about_title" 
                               value="{{ $settings['about_title'] ?? 'Passionate Travel Explorers with High Standards' }}" 
                               class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs font-medium">
                    </div>

                    <div class="sm:col-span-12">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">Story Narrative Paragraph</label>
                        <textarea name="about_description" rows="4" 
                                  class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-4 text-xs leading-relaxed">{{ $settings['about_description'] ?? 'Rango Tour was founded to transform ordinary vacations into meaningful, stress-free adventures. We curate verified routes, partner with licensed local guides, and provide real-time availability with direct support.' }}</textarea>
                    </div>

                    <div class="sm:col-span-6">
                        <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-2 uppercase">About Us Photo</label>
                        <div class="relative rounded-2xl border-2 border-dashed border-zinc-800 bg-black/50 p-6 text-center cursor-pointer overflow-hidden">
                            <input type="file" name="about_image" accept="image/*" @change="fileChosen" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10">
                            <div x-show="!imagePreview" class="py-4">
                                <span class="text-3xl block mb-1">📸</span>
                                <p class="text-xs font-bold text-white uppercase">Upload Story Image</p>
                            </div>
                            <template x-if="imagePreview">
                                <div class="relative h-44 w-full rounded-xl overflow-hidden">
                                    <img :src="imagePreview" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="sm:col-span-6 space-y-4">
                        <div>
                            <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-1 uppercase">Image Badge Title</label>
                            <input type="text" name="about_badge_title" value="{{ $settings['about_badge_title'] ?? 'Certified Local Operator' }}" class="w-full bg-black/80 text-emerald-400 font-bold border border-zinc-800 rounded-2xl p-3 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-mono-code font-bold text-zinc-300 mb-1 uppercase">Image Badge Description</label>
                            <input type="text" name="about_badge_desc" value="{{ $settings['about_badge_desc'] ?? 'Dedicated team delivering verified tour programs throughout Thailand.' }}" class="w-full bg-black/80 text-white border border-zinc-800 rounded-2xl p-3 text-xs">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =========================================================================
             TAB 3: CONTACTS & SOCIAL CHANNELS (WhatsApp, Email, IG, FB)
             ========================================================================= -->
        <div x-show="activeTab === 'contact'" x-transition class="space-y-6">
            <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl space-y-8">
                
                <div class="pb-4 border-b border-zinc-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-wider">Social Media &amp; Direct Contacts</h3>
                        <p class="text-xs text-zinc-400 mt-0.5">These handles, emails, and URLs are displayed on the Contact page, Footer, and Floating Chat Hub.</p>
                    </div>
                    <span class="text-[10px] font-mono-code text-emerald-400 font-bold uppercase bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">4 Main Channels</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- 1. WhatsApp Support -->
                    <div class="p-5 rounded-2xl bg-black/60 border border-zinc-800/80 space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-zinc-800 text-[#25D366]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <h4 class="text-xs font-mono-code font-bold uppercase text-white tracking-wider">WhatsApp Settings</h4>
                        </div>
                        <div>
                            <label class="block text-[11px] font-mono-code font-bold text-zinc-300 mb-1 uppercase">WhatsApp Number (with country code, no +)</label>
                            <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '66812345678' }}" 
                                   placeholder="66812345678"
                                   class="w-full bg-black/80 text-white border border-zinc-800 focus:border-[#25D366] rounded-xl p-3 text-xs focus:outline-none font-mono-code">
                            <span class="text-[10px] text-zinc-500 font-mono-code mt-1 block">E.g., 66812345678 (Thailand 66 + 812345678)</span>
                        </div>
                    </div>

                    <!-- 2. Official Email (เพิ่มแทนที่ LINE) -->
                    <div class="p-5 rounded-2xl bg-black/60 border border-zinc-800/80 space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-zinc-800 text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <h4 class="text-xs font-mono-code font-bold uppercase text-white tracking-wider">Official Email Settings</h4>
                        </div>
                        <div>
                            <label class="block text-[11px] font-mono-code font-bold text-zinc-300 mb-1 uppercase">Contact / Booking Email Address</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? $settings['email'] ?? 'booking@khaosokrangotour.com' }}" 
                                   placeholder="booking@khaosokrangotour.com"
                                   class="w-full bg-black/80 text-white border border-zinc-800 focus:border-amber-500 rounded-xl p-3 text-xs focus:outline-none font-mono-code">
                            <span class="text-[10px] text-zinc-500 font-mono-code mt-1 block">Displayed on Contact page and used for direct customer email links.</span>
                        </div>
                    </div>

                    <!-- 3. Instagram Account -->
                    <div class="p-5 rounded-2xl bg-black/60 border border-zinc-800/80 space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-zinc-800 text-[#E1306C]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            <h4 class="text-xs font-mono-code font-bold uppercase text-white tracking-wider">Instagram Settings</h4>
                        </div>
                        <div>
                            <label class="block text-[11px] font-mono-code font-bold text-zinc-300 mb-1 uppercase">Instagram Handle (e.g. @khaosokrangotour)</label>
                            <input type="text" name="instagram_handle" value="{{ $settings['instagram_handle'] ?? '@khaosokrangotour' }}" 
                                   placeholder="@khaosokrangotour"
                                   class="w-full bg-black/80 text-white border border-zinc-800 focus:border-[#E1306C] rounded-xl p-3 text-xs focus:outline-none font-mono-code">
                        </div>
                        <div>
                            <label class="block text-[11px] font-mono-code font-bold text-zinc-300 mb-1 uppercase">Instagram Profile URL</label>
                            <input type="text" name="instagram_url" value="{{ $settings['instagram_url'] ?? 'https://instagram.com/khaosokrangotour' }}" 
                                   placeholder="https://instagram.com/khaosokrangotour"
                                   class="w-full bg-black/80 text-white border border-zinc-800 focus:border-[#E1306C] rounded-xl p-3 text-xs focus:outline-none font-mono-code">
                        </div>
                    </div>

                    <!-- 4. Facebook Page -->
                    <div class="p-5 rounded-2xl bg-black/60 border border-zinc-800/80 space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-zinc-800 text-[#1877F2]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <h4 class="text-xs font-mono-code font-bold uppercase text-white tracking-wider">Facebook Page Settings</h4>
                        </div>
                        <div>
                            <label class="block text-[11px] font-mono-code font-bold text-zinc-300 mb-1 uppercase">Facebook Page Name</label>
                            <input type="text" name="facebook_name" value="{{ $settings['facebook_name'] ?? 'Khao Sok Rango Tour' }}" 
                                   placeholder="Khao Sok Rango Tour"
                                   class="w-full bg-black/80 text-white border border-zinc-800 focus:border-[#1877F2] rounded-xl p-3 text-xs focus:outline-none font-mono-code">
                        </div>
                        <div>
                            <label class="block text-[11px] font-mono-code font-bold text-zinc-300 mb-1 uppercase">Facebook Page URL</label>
                            <input type="text" name="facebook_url" value="{{ $settings['facebook_url'] ?? 'https://facebook.com/khaosokrangotour' }}" 
                                   placeholder="https://facebook.com/khaosokrangotour"
                                   class="w-full bg-black/80 text-white border border-zinc-800 focus:border-[#1877F2] rounded-xl p-3 text-xs focus:outline-none font-mono-code">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-10 py-4 bg-gradient-to-r from-emerald-500 via-emerald-400 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black uppercase text-xs tracking-wider rounded-2xl shadow-xl shadow-emerald-500/30 hover:scale-[1.02] active:scale-95 transition">
                💾 Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection