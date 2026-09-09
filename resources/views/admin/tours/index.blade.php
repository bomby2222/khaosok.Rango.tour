@extends('layouts.admin')

@section('title', 'TOUR INVENTORY // RANGO TOUR ADMIN')
@section('header', 'TOUR PACKAGES INVENTORY')

@section('content')
<div class="space-y-6" x-data="tourInventoryManager()">

    <!-- Top Command & Action Bar -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-5 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-mono-code uppercase tracking-widest text-emerald-400 font-bold">// INVENTORY CONTROL</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">All Tour Packages</h2>
            <p class="text-xs text-zinc-400 font-mono-code mt-0.5">Manage pricing, day/night duration, schedules, and active calendar availability.</p>
        </div>

        <!-- Search & New Tour Actions -->
        <div class="flex flex-wrap items-center gap-3 z-10">
            <div class="relative w-full sm:w-64">
                <input type="text" x-model="searchQuery" placeholder="Search tour or location..." 
                       class="w-full bg-black/80 text-white placeholder-zinc-500 border border-zinc-800 focus:border-emerald-500 rounded-2xl px-4 py-3 pl-10 text-xs font-mono-code focus:outline-none transition">
                <svg class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <a href="{{ route('admin.tours.create') }}" 
               class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:scale-105 active:scale-95 transition-all duration-200 flex items-center gap-2">
                <span>+</span> Add New Tour
            </a>
        </div>
    </div>

    <!-- Tour Packages Table Container -->
    <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl">
        @if($tours->isEmpty())
            <div class="text-center py-20 border border-dashed border-zinc-800 rounded-3xl space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-3xl shadow-lg">
                    🧭
                </div>
                <h3 class="text-base font-bold text-white uppercase tracking-wider">No Tour Packages Registered</h3>
                <p class="text-xs text-zinc-500 font-mono-code">Start creating your first luxury lake and nature adventure itinerary.</p>
                <a href="{{ route('admin.tours.create') }}" class="inline-block mt-2 px-6 py-3 bg-emerald-500 text-neutral-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg hover:bg-emerald-400 transition">
                    + Create Tour Now
                </a>
            </div>
        @else
            <!-- Responsive Table -->
            <div class="overflow-x-auto -mx-6 sm:mx-0 px-6 sm:px-0">
                <table class="w-full text-left text-xs text-zinc-300 min-w-[900px]">
                    <thead class="bg-black/60 uppercase font-mono-code text-[10px] text-zinc-400 font-bold border-b border-zinc-800">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Cover</th>
                            <th class="p-4">Package Name & Info</th>
                            <th class="p-4">Price / Person</th>
                            <th class="p-4">Duration</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right rounded-r-2xl">Management &amp; Calendar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 font-sans">
                        @foreach($tours as $tour)
                            <tr class="hover:bg-zinc-900/50 transition duration-150 group" 
                                x-show="matchesSearch('{{ strtolower($tour->title . ' ' . $tour->location) }}')">
                                
                                <!-- Cover Thumbnail -->
                                <td class="p-4">
                                    <div class="relative w-16 h-12 rounded-xl overflow-hidden border border-zinc-800 bg-zinc-950 group-hover:border-emerald-500/40 transition">
                                        <img src="{{ asset('storage/' . $tour->cover_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    </div>
                                </td>

                                <!-- Title & Location -->
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-white text-sm block group-hover:text-emerald-400 transition">{{ $tour->title }}</span>
                                        @if($tour->is_featured)
                                            <span class="px-2 py-0.5 rounded text-[9px] font-mono-code font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">FEATURED</span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-zinc-500 font-mono-code block mt-0.5">📍 {{ $tour->location }}</span>
                                </td>

                                <!-- Price -->
                                <td class="p-4 font-mono-code">
                                    <span class="text-emerald-400 font-black text-sm">฿{{ number_format($tour->price) }}</span>
                                </td>

                                <!-- Duration -->
                                <td class="p-4 font-mono-code text-zinc-300">
                                    <span class="px-2.5 py-1 rounded-lg bg-black/60 border border-zinc-800 text-[11px]">
                                        {{ $tour->duration_days }}D {{ $tour->duration_nights }}N
                                    </span>
                                </td>

                                <!-- Status Badge -->
                                <td class="p-4">
                                    @if($tour->status)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-mono-code font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 flex items-center gap-1.5 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> OPEN
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-mono-code font-bold bg-zinc-800 text-zinc-400 border border-zinc-700 w-fit block">
                                            CLOSED
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions Hub -->
                                <td class="p-4 text-right space-x-1.5 font-mono-code text-xs">
                                    <!-- ✏️ Edit Tour Button -->
                                    <a href="{{ route('admin.tours.edit', $tour->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-emerald-500/15 hover:bg-emerald-500 text-emerald-400 hover:text-neutral-950 border border-emerald-500/30 font-bold transition shadow-sm hover:shadow-emerald-500/20"
                                       title="Edit Tour Details">
                                        <span>✏️</span> Edit
                                    </a>

                                    <!-- 📅 ปฏิทินวันว่าง/วันเต็ม -->
                                    <a href="{{ route('admin.tours.calendar', $tour->id) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-950/70 hover:bg-emerald-900 text-emerald-300 hover:text-white border border-emerald-500/40 text-xs font-bold transition shadow-sm hover:shadow-emerald-500/20"
                                       title="Manage Dates & Seats">
                                        <span>📅</span> Calendar
                                    </a>

                                    <!-- Live Front Preview -->
                                    <a href="{{ route('tours.show', $tour->slug) }}" target="_blank" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-800 transition"
                                       title="Preview on Website">
                                        <span>View</span> ↗
                                    </a>

                                    <!-- Custom Delete Trigger -->
                                    <button type="button" 
                                            @click="confirmDelete('{{ $tour->id }}', '{{ addslashes($tour->title) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 text-rose-400 hover:text-rose-300 border border-rose-900/50 transition"
                                            title="Delete Tour">
                                        <span>🗑️</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($tours, 'links'))
                <div class="mt-8 pt-6 border-t border-zinc-800">
                    {{ $tours->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Custom Delete Modal -->
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
             class="glass-panel border border-rose-500/30 rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl relative text-center">
            
            <div class="w-14 h-14 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 mx-auto flex items-center justify-center text-2xl mb-4 shadow-lg shadow-rose-500/10">
                ⚠️
            </div>

            <h3 class="text-lg font-black text-white uppercase tracking-wider mb-2">Delete Tour Package?</h3>
            <p class="text-xs text-zinc-300 leading-relaxed mb-6">
                Are you sure you want to permanently delete <strong class="text-white" x-text="targetTourTitle"></strong>? All calendar schedules and booking records for this tour will be removed.
            </p>

            <form :action="'/rango-admin/tours/' + targetTourId" method="POST" id="deleteTourForm">
                @csrf
                @method('DELETE')
            </form>

            <div class="grid grid-cols-2 gap-3">
                <button type="button" @click="showDeleteModal = false" 
                        class="w-full py-3 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-zinc-300 hover:text-white border border-zinc-700 font-mono-code text-xs font-bold transition">
                    Cancel
                </button>

                <button type="button" @click="document.getElementById('deleteTourForm').submit()" 
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white font-black uppercase text-xs tracking-wider shadow-lg shadow-rose-600/30 active:scale-95 transition">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    function tourInventoryManager() {
        return {
            searchQuery: '',
            showDeleteModal: false,
            targetTourId: null,
            targetTourTitle: '',

            matchesSearch(text) {
                if (!this.searchQuery) return true;
                return text.includes(this.searchQuery.toLowerCase());
            },

            confirmDelete(id, title) {
                this.targetTourId = id;
                this.targetTourTitle = title;
                this.showDeleteModal = true;
            }
        }
    }
</script>
@endsection