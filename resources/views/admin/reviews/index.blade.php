@extends('layouts.admin')

@section('header', 'Customer Reviews & Feedback Moderation')

@section('content')
    <div class="bg-neutral-900 rounded-3xl border border-neutral-800 p-6 sm:p-8 shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 border-b border-neutral-800 pb-6">
            <div>
                <h3 class="text-xl font-black text-white uppercase tracking-tight">All Customer Reviews</h3>
                <p class="text-xs text-neutral-400 mt-1">Moderate user reviews, ratings, and attached trip photographs.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-neutral-950 border border-neutral-800 px-5 py-3 rounded-2xl text-center">
                    <span class="text-[10px] font-mono-code uppercase text-neutral-400 block">Average Rating</span>
                    <span class="text-2xl font-black text-emerald-400">{{ $avgRating }} / 5.0</span>
                </div>
                <div class="bg-neutral-950 border border-neutral-800 px-5 py-3 rounded-2xl text-center">
                    <span class="text-[10px] font-mono-code uppercase text-neutral-400 block">Total Reviews</span>
                    <span class="text-2xl font-black text-white">{{ $totalReviews }}</span>
                </div>
            </div>
        </div>

        @if($reviews->isEmpty())
            <div class="text-center py-16 border border-dashed border-neutral-800 rounded-2xl">
                <span class="text-4xl block mb-2">💬</span>
                <p class="text-xs text-neutral-400">No customer reviews submitted yet.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($reviews as $item)
                    <div class="bg-neutral-950 border border-neutral-800 p-5 sm:p-6 rounded-2xl flex flex-col md:flex-row md:items-start justify-between gap-6 hover:border-emerald-500/30 transition duration-200">
                        <div class="space-y-3 flex-grow">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="font-bold text-white text-sm">{{ $item->name }}</span>
                                @if($item->is_anonymous)
                                    <span class="text-[10px] font-mono-code bg-neutral-800 text-neutral-400 px-2 py-0.5 rounded-md">ANONYMOUS</span>
                                @endif
                                <div class="text-amber-400 text-xs tracking-wider">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span>{{ $s <= $item->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span class="text-[11px] font-mono-code text-neutral-500">• {{ $item->created_at->format('d M Y H:i') }} ({{ $item->created_at->diffForHumans() }})</span>
                            </div>

                            <p class="text-neutral-300 text-xs sm:text-sm leading-relaxed whitespace-pre-line bg-neutral-900/60 p-4 rounded-xl border border-neutral-800/80">
                                "{{ $item->comment }}"
                            </p>

                            @if($item->images && $item->images->count() > 0)
                                <div class="flex flex-wrap gap-2 pt-1">
                                    @foreach($item->images as $img)
                                        <a href="{{ asset('storage/' . $img->image) }}" target="_blank" class="w-16 h-16 rounded-xl overflow-hidden border border-neutral-800 hover:scale-105 transition">
                                            <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover">
                                        </a>
                                    @endforeach
                                </div>
                            @elseif($item->image)
                                <div class="pt-1">
                                    <a href="{{ asset('storage/' . $item->image) }}" target="_blank" class="w-16 h-16 inline-block rounded-xl overflow-hidden border border-neutral-800">
                                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="shrink-0 flex md:flex-col justify-end">
                            <form action="{{ route('admin.reviews.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this review permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-950/60 hover:bg-rose-900 text-rose-300 border border-rose-800/60 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                                    <span>🗑️</span> Delete Review
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
@endsection