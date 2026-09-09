@extends('layouts.admin')

@section('title', 'LAKE RESORTS // RANGO ADMIN')
@section('header', 'CHEOW LAN LAKE RESORTS & BUNGALOWS')

@section('content')
<div class="space-y-6 sm:space-y-8" x-data="resortsManager()">

    <!-- Top Command Bar -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-5 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-mono-code uppercase tracking-widest text-emerald-400 font-bold">// WELCOME TO KHAO SOK TOUR</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Lake Resorts &amp; Raft Houses</h2>
            <p class="text-xs text-zinc-400 font-mono-code mt-0.5">Manage floating bungalows displayed in the "Welcome to Khao Sok Tour" homepage section.</p>
        </div>

        <!-- Search & Action Buttons -->
        <div class="flex flex-wrap items-center gap-3 z-10">
            <!-- Search Input -->
            <div class="relative w-full sm:w-60">
                <input type="text" x-model="searchQuery" placeholder="Search resort name..." 
                       class="w-full bg-black/80 text-white placeholder-zinc-500 border border-zinc-800 focus:border-emerald-500 rounded-2xl px-4 py-3 pl-10 text-xs font-mono-code focus:outline-none transition">
                <svg class="w-4 h-4 text-zinc-500 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <a href="{{ route('admin.resorts.create') }}" 
               class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:scale-105 active:scale-95 transition-all duration-200 flex items-center gap-2">
                <span>+</span> Add Lake Resort
            </a>
        </div>
    </div>

    <!-- Resorts Showcase Grid -->
    <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl">
        @if($resorts->isEmpty())
            <div class="text-center py-20 border border-dashed border-zinc-800 rounded-3xl space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-3xl shadow-lg">
                    🛶
                </div>
                <h3 class="text-base font-bold text-white uppercase tracking-wider">No Floating Resorts Added Yet</h3>
                <p class="text-xs text-zinc-500 font-mono-code">Add floating bungalows like The Laguna, Panvaree, Saichol, or Klongka.</p>
                <a href="{{ route('admin.resorts.create') }}" class="inline-block mt-2 px-6 py-3 bg-emerald-500 text-neutral-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg hover:bg-emerald-400 transition">
                    + Add First Resort
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($resorts as $resort)
                    <div class="bg-black/60 rounded-3xl overflow-hidden border border-zinc-800/80 flex flex-col justify-between group hover:border-emerald-500/40 hover:shadow-2xl hover:shadow-emerald-500/10 transition duration-300"
                         x-show="matchesSearch('{{ strtolower($resort->name . ' ' . ($resort->prefix ?? '') . ' ' . ($resort->subtitle ?? '')) }}')">
                        
                        <!-- Preview Card Media -->
                        <div class="relative aspect-[3/4] overflow-hidden bg-neutral-950">
                            <img src="{{ asset('storage/' . $resort->image) }}" alt="{{ $resort->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-85">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/25 to-black/60"></div>

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

                            <span class="absolute bottom-3 left-3 bg-black/80 backdrop-blur border border-zinc-800 text-[9px] font-mono-code text-zinc-400 px-2.5 py-0.5 rounded-md">
                                Sort #{{ $resort->sort_order }}
                            </span>
                        </div>

                        <!-- Card Actions (Edit, Preview, Delete) -->
                        <div class="p-3.5 border-t border-zinc-900 flex items-center justify-between gap-2 bg-neutral-950/60">
                            <span class="text-[10px] font-mono-code text-emerald-400 font-bold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                            </span>

                            <div class="flex items-center gap-1.5">
                                <!-- ✏️ Edit Button -->
                                <a href="{{ route('admin.resorts.edit', $resort->id) }}" 
                                   class="px-2.5 py-1.5 rounded-xl bg-emerald-500/15 hover:bg-emerald-500 text-emerald-400 hover:text-neutral-950 border border-emerald-500/30 text-[11px] font-mono-code font-bold transition flex items-center gap-1"
                                   title="Edit Resort">
                                    <span>✏️</span> Edit
                                </a>

                                <!-- Delete Button -->
                                <button type="button" 
                                        @click="confirmDelete('{{ $resort->id }}', '{{ addslashes($resort->name) }}')"
                                        class="p-1.5 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 text-rose-400 hover:text-rose-300 border border-rose-900/50 text-xs transition"
                                        title="Delete Resort">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Custom Delete Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-md p-4">
        <div @click.away="showDeleteModal = false" class="glass-panel border border-rose-500/30 rounded-3xl max-w-md w-full p-6 text-center shadow-2xl">
            <div class="w-14 h-14 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 mx-auto flex items-center justify-center text-2xl mb-4">⚠️</div>
            <h3 class="text-lg font-black text-white uppercase tracking-wider mb-2">Delete Lake Resort?</h3>
            <p class="text-xs text-zinc-300 mb-6">Are you sure you want to remove <strong class="text-white" x-text="targetName"></strong> from the homepage?</p>
            <form :action="'/rango-admin/resorts/' + targetId" method="POST" id="deleteResortForm">
                @csrf
                @method('DELETE')
            </form>
            <div class="grid grid-cols-2 gap-3">
                <button type="button" @click="showDeleteModal = false" class="py-3 rounded-xl bg-zinc-900 text-zinc-300 text-xs font-bold">Cancel</button>
                <button type="button" @click="document.getElementById('deleteResortForm').submit()" class="py-3 rounded-xl bg-rose-600 text-white font-black text-xs uppercase">Yes, Delete</button>
            </div>
        </div>
    </div>

</div>

<script>
    function resortsManager() {
        return {
            searchQuery: '',
            showDeleteModal: false,
            targetId: null,
            targetName: '',

            matchesSearch(text) {
                if (!this.searchQuery) return true;
                return text.includes(this.searchQuery.toLowerCase());
            },

            confirmDelete(id, name) {
                this.targetId = id;
                this.targetName = name;
                this.showDeleteModal = true;
            }
        }
    }
</script>
@endsection