@extends('layouts.app')

@section('title', 'Tour Packages - Rango Tour')

@section('content')
    <div class="bg-emerald-900 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-emerald-300 font-bold text-xs uppercase tracking-widest">Handcrafted Itineraries</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold mt-2">All Tour Packages</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($tours->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200">
                <p class="text-slate-500 text-sm">No active tour packages available right now.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($tours as $tour)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-slate-100 flex flex-col group">
                        <div class="relative h-60 overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/' . $tour->cover_image) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-semibold px-3 py-1 rounded-full">
                                📍 {{ $tour->location }}
                            </span>
                            <span class="absolute top-4 right-4 bg-emerald-500 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
                                {{ $tour->duration_days }}D {{ $tour->duration_nights }}N
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-lg text-slate-900 line-clamp-1 group-hover:text-emerald-600 transition">{{ $tour->title }}</h3>
                            <p class="text-slate-500 text-xs mt-2 line-clamp-2 leading-relaxed flex-grow">{{ $tour->description }}</p>
                            <div class="border-t border-slate-100 pt-4 mt-5 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Starting from</span>
                                    <span class="text-2xl font-black text-slate-900">฿{{ number_format($tour->price) }}</span>
                                    <span class="text-xs text-slate-400">/ person</span>
                                </div>
                                <a href="{{ route('tours.show', $tour->slug) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $tours->links() }}
            </div>
        @endif
    </div>
@endsection