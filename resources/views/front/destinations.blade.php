@extends('layouts.app')

@section('title', 'Best Tours & Landmarks - Khao Sok Rango Tour')

@section('content')
<div x-data="bestToursManager()" 
     @keydown.escape.window="closeModal()" 
     class="relative space-y-12 sm:space-y-16 overflow-hidden py-10">

    <!-- Ambient Glowing Background Orbs -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-emerald-500/10 rounded-full blur-[150px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-10 right-0 w-[600px] h-[500px] bg-teal-500/10 rounded-full blur-[170px] pointer-events-none -z-10"></div>

    <!-- Top Header Banner -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-emerald-950/60 border border-emerald-500/30 backdrop-blur-xl shadow-xl">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span class="text-[10px] sm:text-xs font-mono-code font-bold uppercase tracking-[0.25em] text-emerald-300">
                Handcrafted Expedition Highlights
            </span>
        </div>
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-white uppercase tracking-tight">
            Best Tours &amp; Landmarks
        </h1>
        <p class="text-xs sm:text-sm md:text-base text-neutral-400 max-w-2xl mx-auto font-normal leading-relaxed">
            Discover our hand-picked Khao Sok limestone peaks, hidden caverns, and lake sanctuaries. Click any photo below to reveal detailed descriptions, highlights, and instant booking options.
        </p>
    </div>

    <!-- Main Grid Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($destinations->isEmpty())
            <div class="text-center py-20 bg-neutral-900/60 rounded-3xl border border-neutral-800">
                <span class="text-3xl block mb-2">🌿</span>
                <p class="text-neutral-400 text-xs font-mono-code uppercase">No tour destinations available right now.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($destinations as $dest)
                    <div @click="openModal('{{ addslashes($dest->name) }}', '{{ asset('storage/' . $dest->image) }}', '{{ addslashes($dest->country ?? 'Thailand') }}', '{{ addslashes($dest->description) }}')"
                         class="group relative rounded-3xl overflow-hidden bg-neutral-900 border border-neutral-800 hover:border-emerald-500/60 shadow-2xl h-96 transition-all duration-500 hover:-translate-y-1.5 cursor-pointer flex flex-col justify-end">
                        
                        <!-- Destination Image with Hover Zoom -->
                        <img src="{{ asset('storage/' . $dest->image) }}" 
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-85" 
                             alt="{{ $dest->name }}">
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                        
                        <!-- Click To View Prompt Badge -->
                        <div class="absolute top-4 right-4 bg-black/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-neutral-700 text-[10px] font-mono-code text-emerald-300 opacity-90 group-hover:border-emerald-400 flex items-center gap-1.5 shadow-lg">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Click to Read</span>
                        </div>

                        <!-- Card Content Summary -->
                        <div class="relative z-10 p-6 space-y-2">
                            <span class="inline-block text-[10px] font-mono-code font-bold uppercase tracking-wider bg-emerald-500 text-neutral-950 px-3 py-1 rounded-full shadow">
                                {{ $dest->country ?? 'Thailand' }}
                            </span>
                            <h3 class="text-xl sm:text-2xl font-black text-white uppercase group-hover:text-emerald-400 transition leading-snug">
                                {{ $dest->name }}
                            </h3>
                            <p class="text-xs text-neutral-300 line-clamp-2 leading-relaxed">
                                {{ $dest->description }}
                            </p>
                            <span class="text-[11px] font-mono-code text-emerald-400 font-bold block pt-1">
                                View Full Explanation ➔
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>

    <!-- =========================================================================
         MODAL: EXPEDITION PHOTO & STORY EXPLANATION
         ========================================================================= -->
    <div x-show="isModalOpen" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-xl p-4 select-none">
        
        <div @click.away="closeModal()" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-neutral-900 border border-emerald-500/30 rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 bg-black/85 border-b border-neutral-800 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-mono-code font-bold uppercase tracking-widest text-emerald-400" x-text="activeCountry"></span>
                </div>
                <button type="button" @click="closeModal()" 
                        class="w-8 h-8 rounded-full bg-neutral-800 hover:bg-neutral-700 text-neutral-300 hover:text-white flex items-center justify-center font-mono-code text-sm transition">
                    ✕
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="overflow-y-auto p-6 space-y-5">
                
                <!-- Zoomed Image Container -->
                <div class="relative aspect-video rounded-2xl overflow-hidden border border-neutral-800 shadow-inner bg-black">
                    <img :src="activeImage" :alt="activeTitle" class="w-full h-full object-cover">
                </div>

                <!-- Explanation & Full Narrative Text -->
                <div class="space-y-3">
                    <h2 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight" x-text="activeTitle"></h2>
                    <div class="h-0.5 w-16 bg-gradient-to-r from-emerald-400 to-teal-300 rounded-full"></div>
                    <p class="text-xs sm:text-sm text-neutral-300 leading-relaxed whitespace-pre-line font-normal" x-text="activeDescription"></p>
                </div>
            </div>

            <!-- Modal Bottom CTA Bar -->
            <div class="p-4 sm:p-5 bg-black/90 border-t border-neutral-800 flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
                <span class="text-[11px] font-mono-code text-neutral-400">Want to visit this landmark?</span>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="button" @click="closeModal()" 
                            class="flex-grow sm:flex-grow-0 px-4 py-2.5 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-mono-code text-xs uppercase font-bold transition">
                        Close
                    </button>
                    <button type="button" 
                            @click="inquireThisLandmark()" 
                            class="flex-grow sm:flex-grow-0 px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-neutral-950 font-black uppercase text-xs tracking-wider shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-1.5">
                        <span>💬 Inquire in Live Chat</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Alpine Script Engine -->
<script>
    function bestToursManager() {
        return {
            isModalOpen: false,
            activeTitle: '',
            activeImage: '',
            activeCountry: '',
            activeDescription: '',

            openModal(title, image, country, description) {
                this.activeTitle = title;
                this.activeImage = image;
                this.activeCountry = country;
                this.activeDescription = description;
                this.isModalOpen = true;
            },

            closeModal() {
                this.isModalOpen = false;
            },

            inquireThisLandmark() {
                const tourName = this.activeTitle;
                this.closeModal();
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('open-rango-chat', {
                        detail: { message: 'Hello! I would like to inquire about visiting: ' + tourName }
                    }));
                }, 300);
            }
        }
    }
</script>
@endsection