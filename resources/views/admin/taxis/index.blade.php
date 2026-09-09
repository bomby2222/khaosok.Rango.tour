@extends('layouts.admin')

@section('title', 'TAXI & TRANSFERS // RANGO ADMIN')
@section('header', 'TAXI & PRIVATE TRANSFER FLEET')

@section('content')
<div class="space-y-6" x-data="{ currentTab: 'all' }">
    <!-- Top Action Card -->
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-emerald-500/20 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-mono-code uppercase tracking-widest text-emerald-400 font-bold">// 4 DESTINATIONS &amp; SUB-ROUTES</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black uppercase text-white tracking-tight">Taxi &amp; Transfers Fleet Management</h2>
            <p class="text-xs text-zinc-400 font-mono-code mt-0.5">Manage private charters and shared transfer routes across Phuket, Khao Sok, Phang Nga, and Krabi.</p>
        </div>

        <a href="{{ route('admin.taxis.create') }}" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-400 text-neutral-950 font-black text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition flex items-center gap-2 self-start md:self-auto">
            <span>+</span> Add New Route
        </a>
    </div>

    <!-- Zone Filter Tabs -->
    <div class="flex flex-wrap items-center gap-2 bg-black/60 p-1.5 rounded-2xl border border-zinc-800 w-fit">
        <button type="button" @click="currentTab = 'all'" :class="currentTab === 'all' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-mono-code uppercase transition">
            All Zones ({{ $taxis->count() }})
        </button>
        <button type="button" @click="currentTab = 'phuket'" :class="currentTab === 'phuket' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-mono-code uppercase transition">
            🏝️ Phuket ({{ $taxis->where('zone', 'phuket')->count() }})
        </button>
        <button type="button" @click="currentTab = 'khaosok'" :class="currentTab === 'khaosok' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-mono-code uppercase transition">
            🛶 Khao Sok ({{ $taxis->where('zone', 'khaosok')->count() }})
        </button>
        <button type="button" @click="currentTab = 'phangnga'" :class="currentTab === 'phangnga' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-mono-code uppercase transition">
            ⛰️ Phang Nga ({{ $taxis->where('zone', 'phangnga')->count() }})
        </button>
        <button type="button" @click="currentTab = 'krabi'" :class="currentTab === 'krabi' ? 'bg-emerald-500 text-black font-black' : 'text-zinc-400 hover:text-white'" class="px-4 py-2 rounded-xl text-xs font-mono-code uppercase transition">
            🏖️ Krabi ({{ $taxis->where('zone', 'krabi')->count() }})
        </button>
    </div>

    <!-- Taxis Table -->
    <div class="glass-panel rounded-3xl border border-emerald-500/15 p-6 shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-zinc-300 min-w-[860px]">
                <thead class="bg-black/60 font-mono-code text-[10px] text-zinc-400 uppercase border-b border-zinc-800">
                    <tr>
                        <th class="p-3">Zone</th>
                        <th class="p-3">Route Name &amp; Endpoints</th>
                        <th class="p-3">Vehicle</th>
                        <th class="p-3">Private Charter</th>
                        <th class="p-3">Per Person</th>
                        <th class="p-3">Duration / Schedule</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60 font-sans">
                    @forelse($taxis as $taxi)
                        @php
                            $displayTitle = !empty($taxi->route_name) 
                                ? $taxi->route_name 
                                : (($taxi->from_location ?? '') . (!empty($taxi->to_location) ? ' ➔ ' . $taxi->to_location : 'General Transfer Route'));
                        @endphp
                        <tr class="hover:bg-zinc-900/50 transition-colors" x-show="currentTab === 'all' || currentTab === '{{ $taxi->zone }}'">
                            <td class="p-3">
                                @if($taxi->zone == 'phuket')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-mono-code font-bold bg-blue-500/15 text-blue-400 border border-blue-500/30">🏝️ Phuket</span>
                                @elseif($taxi->zone == 'khaosok')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-mono-code font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">🛶 Khao Sok</span>
                                @elseif($taxi->zone == 'phangnga')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-mono-code font-bold bg-teal-500/15 text-teal-400 border border-teal-500/30">⛰️ Phang Nga</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-mono-code font-bold bg-amber-500/15 text-amber-400 border border-amber-500/30">🏖️ Krabi</span>
                                @endif
                            </td>

                            <td class="p-3">
                                <div class="font-bold text-white text-sm">
                                    {{ $displayTitle }}
                                </div>
                                @if(!empty($taxi->from_location) && !empty($taxi->to_location) && !empty($taxi->route_name))
                                    <div class="text-[11px] font-mono-code text-zinc-400 flex items-center gap-1.5 mt-0.5">
                                        <span>{{ $taxi->from_location }}</span>
                                        <span class="text-emerald-400">➔</span>
                                        <span>{{ $taxi->to_location }}</span>
                                    </div>
                                @endif
                                @if(!empty($taxi->description))
                                    <span class="text-[11px] text-zinc-500 block mt-0.5 line-clamp-1">{{ $taxi->description }}</span>
                                @endif
                            </td>

                            <td class="p-3 font-mono-code text-zinc-300">
                                🚗 {{ $taxi->vehicle_type }}
                            </td>

                            <!-- Private Charter Price -->
                            <td class="p-3 font-mono-code font-bold text-emerald-400 text-sm">
                                ฿{{ number_format($taxi->price) }}
                                <span class="text-[9px] text-zinc-500 font-normal block">/ vehicle</span>
                            </td>

                            <!-- Price Per Person -->
                            <td class="p-3 font-mono-code font-bold text-teal-300 text-sm">
                                @if(!empty($taxi->price_per_person) && $taxi->price_per_person > 0)
                                    ฿{{ number_format($taxi->price_per_person) }}
                                    <span class="text-[9px] text-zinc-500 font-normal block">/ person</span>
                                @else
                                    <span class="text-zinc-600 font-normal text-xs">-</span>
                                @endif
                            </td>

                            <td class="p-3 font-mono-code text-[11px] text-zinc-400">
                                <span>⏱️ {{ $taxi->duration ?: 'On-Demand' }}</span>
                                <span class="block text-zinc-500 text-[10px]">{{ $taxi->pickup_times ?: ($taxi->schedule_times ?: '24/7 Available') }}</span>
                            </td>

                            <td class="p-3">
                                @if($taxi->status)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-mono-code font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        ACTIVE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono-code font-bold bg-zinc-800 text-zinc-500 border border-zinc-700">
                                        OFFLINE
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 text-right space-x-2 font-mono-code">
                                <a href="{{ route('admin.taxis.edit', $taxi->id) }}" class="px-2.5 py-1 bg-emerald-500/15 hover:bg-emerald-500 text-emerald-400 hover:text-black rounded-lg text-xs font-bold transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.taxis.destroy', $taxi->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this route?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-zinc-500 font-mono-code">No transfer routes found in the database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection