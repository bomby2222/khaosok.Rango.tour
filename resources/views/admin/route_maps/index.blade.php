@extends('layouts.admin')

@section('title', 'INTERACTIVE ROUTE MAPS // RANGO ADMIN')
@section('header', 'ROUTE MAPS & WAYPOINTS BUILDER')

@section('content')
<div class="space-y-6">

    <!-- Command Header -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/20 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-5 relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-mono-code uppercase tracking-widest text-emerald-400 font-bold">// NAVIGATION CORE</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Interactive Route Maps</h2>
            <p class="text-xs text-zinc-400 font-mono-code mt-0.5">Plot waypoints, boat/minivan pathways, and coordinates for visitor routes.</p>
        </div>

        <a href="{{ route('admin.route-maps.create') }}" 
           class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-neutral-950 font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:scale-105 active:scale-95 transition-all duration-200 flex items-center gap-2">
            <span>+</span> Build New Route Map
        </a>
    </div>

    <!-- Table Container -->
    <div class="glass-panel rounded-3xl sm:rounded-[2.5rem] border border-emerald-500/15 p-6 sm:p-8 shadow-2xl">
        @if($routeMaps->isEmpty())
            <div class="text-center py-20 border border-dashed border-zinc-800 rounded-3xl space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mx-auto flex items-center justify-center text-3xl shadow-lg">🗺️</div>
                <h3 class="text-base font-bold text-white uppercase tracking-wider">No Route Maps Created Yet</h3>
                <p class="text-xs text-zinc-500 font-mono-code">Create interconnected GPS lines for your Khao Sok tour routes.</p>
                <a href="{{ route('admin.route-maps.create') }}" class="inline-block mt-2 px-6 py-3 bg-emerald-500 text-neutral-950 font-black text-xs uppercase tracking-wider rounded-xl shadow-lg hover:bg-emerald-400 transition">
                    + Create First Route Map
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-zinc-300">
                    <thead class="bg-black/60 uppercase font-mono-code text-[10px] text-zinc-400 font-bold border-b border-zinc-800">
                        <tr>
                            <th class="p-4 rounded-l-2xl">Route Title</th>
                            <th class="p-4">Linked Tour</th>
                            <th class="p-4">Waypoints (จุดแวะ)</th>
                            <th class="p-4">Color</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right rounded-r-2xl">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 font-sans">
                        @foreach($routeMaps as $map)
                            <tr class="hover:bg-zinc-900/50 transition duration-150">
                                <td class="p-4">
                                    <span class="font-bold text-white text-sm block">{{ $map->title }}</span>
                                    <span class="text-[11px] text-zinc-500 font-mono-code">{{ $map->slug }}</span>
                                </td>
                                <td class="p-4">
                                    @if($map->tour)
                                        <span class="px-2.5 py-1 rounded-lg bg-emerald-950/60 border border-emerald-500/30 text-emerald-300 text-xs font-medium">
                                            {{ $map->tour->title }}
                                        </span>
                                    @else
                                        <span class="text-zinc-500 font-mono-code">General Map</span>
                                    @endif
                                </td>
                                <td class="p-4 font-mono-code">
                                    <span class="px-2.5 py-1 rounded-full bg-black border border-zinc-800 text-emerald-400 font-bold">
                                        📍 {{ count($map->waypoints ?? []) }} Points
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-4 h-4 rounded-full border border-white/20" style="background-color: {{ $map->route_color }};"></span>
                                        <span class="font-mono-code text-[11px] text-zinc-400">{{ $map->route_color }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    @if($map->status)
                                        <span class="text-emerald-400 font-mono-code font-bold text-[11px]">● ACTIVE</span>
                                    @else
                                        <span class="text-zinc-500 font-mono-code text-[11px]">OFFLINE</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right space-x-2 font-mono-code">
                                    <a href="{{ route('admin.route-maps.edit', $map->id) }}" class="px-3 py-1.5 rounded-xl bg-emerald-500/15 hover:bg-emerald-500 text-emerald-400 hover:text-black font-bold transition">
                                        ✏️ Edit Map
                                    </a>
                                    <form action="{{ route('admin.route-maps.destroy', $map->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this route map?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 text-rose-400 transition">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $routeMaps->links() }}
            </div>
        @endif
    </div>

</div>
@endsection