@extends('layouts.admin')

@section('title', 'BEST TOURS // RANGO ADMIN')
@section('header', 'BEST TOURS & LANDMARKS HUB')

@section('content')
<div class="space-y-6 sm:space-y-8" x-data="destinationsManager()">

    <!-- Top Command & Action Bar -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-5 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-mono-code uppercase tracking-widest text-emerald-400 font-bold">// BEST TOURS &amp; LANDMARKS</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Best Tours &amp; Landmark Showcases</h2>
            <p class="text-xs text-zinc-400 font-mono-code mt-0.5">Manage photo galleries, detailed descriptions, and popup explanations for the Best Tours page.</p>
        </div>

        <!-- Search & New Destination Actions -->
        <div class="flex flex-wrap items-center gap-3 z-10">
            <!-- Live Search Bar -->
            <div class="relative w-full sm:w-64">
                <input type="text" x-model="searchQuery" placeholder="Search tour or landmark..." 
                       class="w-full bg-black/80 text-white placeholder-zinc-500 border border-zinc-800 focus:border-emerald-500 rounded-2xl px-4 py-3 pl-10 text-xs font-mono-code focus:outline-none transition">
                <svg class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <a href="{{ route('admin.destinations.create') }}" 
               class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:scale-105 active:scale-95 transition-all duration-200 flex items-center gap-2">
                <span>+</span> Add Best Tour
            </a>
        </div>
    </div>

    <!-- Destinations Grid Container -->
    <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl">
        @if($destinations->isEmpty())
            <div class="text-center py-20 border border-dashed border-zinc-800 rounded-3xl space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-3xl shadow-lg">
                    🏝️
                </div>
                <h3 class="text-base font-bold text-white uppercase tracking-wider">No Best Tours Created Yet</h3>
                <p class="text-xs text-zinc-500 font-mono-code">Add your first landmark or bamboo rafting highlight.</p>
                <a href="{{ route('admin.destinations.create') }}" class="inline-block mt-2 px-6 py-3 bg-emerald-500 text-neutral-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg hover:bg-emerald-400 transition">
                    + Create Best Tour Now
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($destinations as $dest)
                    <div class="bg-black/60 rounded-3xl overflow-hidden border border-zinc-800/80 flex flex-col justify-between group hover:border-emerald-500/40 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300"
                         x-show="matchesSearch('{{ strtolower($dest->name . ' ' . ($dest->country ?? 'Thailand')) }}')">
                        
                        <div>
                            <!-- Image & Country Badge -->
                            <div class="relative h-52 sm:h-56 overflow-hidden bg-neutral-950">
                                <img src="{{ asset('storage/' . $dest->image) }}" alt="{{ $dest->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700 opacity-90">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                
                                <span class="absolute top-4 left-4 bg-emerald-500/90 backdrop-blur text-neutral-950 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-lg">
                                    {{ $dest->country ?? 'Thailand' }}
                                </span>

                                <span class="absolute top-4 right-4 bg-black/70 backdrop-blur border border-zinc-800 text-[10px] font-mono-code font-bold text-zinc-400 px-2.5 py-1 rounded-xl">
                                    Sort #{{ $dest->sort_order }}
                                </span>
                            </div>

                            <!-- Content Details -->
                            <div class="p-6 space-y-2">
                                <h4 class="font-black text-white text-base sm:text-lg group-hover:text-emerald-400 transition tracking-tight">
                                    {{ $dest->name }}
                                </h4>
                                
                                @if(!empty(trim($dest->description)))
                                    <p class="text-xs text-zinc-400 line-clamp-3 leading-relaxed font-sans">
                                        {{ $dest->description }}
                                    </p>
                                @else
                                    <p class="text-[11px] text-amber-400/90 italic font-mono-code bg-amber-500/10 border border-amber-500/20 p-2.5 rounded-xl">
                                        ⚠️ No explanation text added yet. Click Edit below to insert description.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Card Bottom Bar & Actions (Edit / Preview / Delete) -->
                        <div class="p-6 pt-0 border-t border-zinc-900/90 flex items-center justify-between mt-4">
                            <span class="text-[10px] font-mono-code text-zinc-500 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                            </span>

                            <div class="flex items-center gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.destinations.edit', $dest->id) }}" 
                                   class="px-3.5 py-1.5 rounded-xl bg-emerald-500/15 hover:bg-emerald-500 text-emerald-400 hover:text-neutral-950 border border-emerald-500/30 font-mono-code text-xs font-bold transition flex items-center gap-1"
                                   title="Edit Description & Details">
                                    <span>✏️</span> Edit
                                </a>

                                <!-- Preview Front Page -->
                                <a href="{{ route('destinations') }}" target="_blank" 
                                   class="px-3 py-1.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 font-mono-code text-xs transition">
                                    Preview ↗
                                </a>

                                <!-- Delete Button -->
                                <button type="button" 
                                        @click="confirmDelete('{{ $dest->id }}', '{{ addslashes($dest->name) }}')"
                                        class="p-2 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 text-rose-400 hover:text-rose-300 border border-rose-900/50 text-xs font-mono-code transition duration-200"
                                        title="Delete Destination">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($destinations, 'links'))
                <div class="mt-8 pt-6 border-t border-zinc-800">
                    {{ $destinations->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- =========================================================================
         CUSTOM DARK EMERALD DELETE MODAL
         ========================================================================= -->
    <div x-show="showDeleteModal" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4">
        
        <div @click.away="showDeleteModal = false"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="glass-panel border border-rose-500/30 rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl relative text-center">
            
            <div class="w-14 h-14 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 mx-auto flex items-center justify-center text-2xl mb-4 shadow-lg shadow-rose-500/10">
                ⚠️
            </div>

            <h3 class="text-lg font-black text-white uppercase tracking-wider mb-2">Delete Destination?</h3>
            <p class="text-xs text-zinc-300 leading-relaxed mb-6">
                Are you sure you want to delete <strong class="text-white" x-text="targetDestName"></strong>? This item will be permanently removed from the website showcases.
            </p>

            <form :action="'/rango-admin/destinations/' + targetDestId" method="POST" id="deleteDestForm">
                @csrf
                @method('DELETE')
            </form>

            <div class="grid grid-cols-2 gap-3">
                <button type="button" @click="showDeleteModal = false" 
                        class="w-full py-3 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-700 font-mono-code text-xs font-bold transition">
                    Cancel
                </button>

                <button type="button" @click="document.getElementById('deleteDestForm').submit()" 
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white font-black uppercase text-xs tracking-wider shadow-lg shadow-rose-600/30 active:scale-95 transition">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Alpine Script Engine -->
<script>
    function destinationsManager() {
        return {
            searchQuery: '',
            showDeleteModal: false,
            targetDestId: null,
            targetDestName: '',

            matchesSearch(text) {
                if (!this.searchQuery) return true;
                return text.includes(this.searchQuery.toLowerCase());
            },

            confirmDelete(id, name) {
                this.targetDestId = id;
                this.targetDestName = name;
                this.showDeleteModal = true;
            }
        }
    }
</script>
@endsection