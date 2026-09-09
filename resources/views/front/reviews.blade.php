@extends('layouts.app')

@section('title', 'Customer Reviews & Ratings - Rango Tour')

@section('content')
    <!-- Banner Title Header -->
    <div class="bg-emerald-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-emerald-300 font-bold text-xs uppercase tracking-widest bg-emerald-800/60 px-3 py-1 rounded-md border border-emerald-700">
                Community Feedback
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold mt-2">Customer Reviews & Ratings</h1>
            <p class="text-xs sm:text-sm text-emerald-200 mt-2 max-w-xl">
                Read authentic feedback from travelers or share your own experience with Rango Tour.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm">
                <span class="text-xl">✅</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- 1. Rating Summary Widget (ส่วนสรุปดาว 1-5 ดาว ด้านบนสุด) -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-100 mb-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <!-- Average Score Box -->
                <div class="text-center lg:text-left lg:border-r border-slate-100 lg:pr-8">
                    <span class="text-xs uppercase tracking-widest font-bold text-slate-400">Overall Rating</span>
                    <div class="flex items-baseline justify-center lg:justify-start gap-2 mt-2">
                        <span class="text-5xl sm:text-6xl font-black text-slate-900">{{ $avgRating > 0 ? $avgRating : '5.0' }}</span>
                        <span class="text-slate-400 text-sm font-semibold">/ 5.0</span>
                    </div>
                    
                    <div class="flex justify-center lg:justify-start gap-1 my-2 text-amber-400 text-xl">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= round($avgRating) ? '★' : '☆' }}</span>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-500 font-medium">Based on {{ number_format($totalReviews) }} traveler reviews</p>
                </div>

                <!-- Star Rating Breakdown Bars (กราฟแท่งคะแนน 5-1 ดาว) -->
                <div class="lg:col-span-2 space-y-2.5">
                    @for($star = 5; $star >= 1; $star--)
                        <div class="flex items-center gap-3 text-xs">
                            <span class="w-12 font-bold text-slate-600 flex items-center gap-1">{{ $star }} ★</span>
                            <div class="flex-grow bg-slate-100 h-3 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-700" 
                                     style="width: {{ $starPercentages[$star] }}%"></div>
                            </div>
                            <span class="w-10 text-right text-slate-400 font-medium">{{ $starPercentages[$star] }}%</span>
                            <span class="w-8 text-right text-slate-500 font-semibold">({{ $starCounts[$star] }})</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">
            <!-- 2. Interactive Review Submission Form (แก้ไขให้ static บนมือถือ และ sticky เฉพาะจอคอม lg:) -->
            <div class="lg:col-span-1 bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-100 static lg:sticky lg:top-28 z-10 mb-8 lg:mb-0" 
                 x-data="{ 
                    rating: 5, 
                    hoverRating: 0,
                    isAnonymous: false,
                    previews: [],
                    handleFiles(event) {
                        this.previews = [];
                        const files = event.target.files;
                        for (let i = 0; i < files.length; i++) {
                            this.previews.push(URL.createObjectURL(files[i]));
                        }
                    }
                 }">
                <h3 class="text-lg font-bold text-slate-900 mb-1">Leave a Review</h3>
                <p class="text-xs text-slate-500 mb-6">Share your travel story, photos, and ratings.</p>

                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Rating Star Selector -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Your Rating *</label>
                        <input type="hidden" name="rating" :value="rating">
                        <div class="flex items-center gap-2">
                            <template x-for="star in 5">
                                <button type="button" 
                                        @click="rating = star"
                                        @mouseenter="hoverRating = star"
                                        @mouseleave="hoverRating = 0"
                                        class="text-3xl focus:outline-none transition-transform active:scale-125"
                                        :class="(hoverRating ? hoverRating >= star : rating >= star) ? 'text-amber-400' : 'text-slate-300'">
                                    ★
                                </button>
                            </template>
                            <span class="text-xs font-bold text-emerald-700 ml-2" x-text="rating + ' Stars'"></span>
                        </div>
                    </div>

                    <!-- Post Anonymously Checkbox -->
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input type="checkbox" name="is_anonymous" value="1" x-model="isAnonymous" class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                            <span class="text-xs font-semibold text-slate-700">Post as Anonymous (ไม่ระบุตัวตน)</span>
                        </label>
                    </div>

                    <!-- Name Field (disabled if anonymous) -->
                    <div x-show="!isAnonymous" x-transition>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Your Name</label>
                        <input type="text" name="name" placeholder="e.g. John Doe" class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <!-- Review Comment -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Your Feedback / Story *</label>
                        <textarea name="comment" rows="4" required placeholder="Tell us what you loved about your trip, the tour guide, or scenery..." class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none leading-relaxed"></textarea>
                    </div>

                    <!-- Multiple Image Upload (แนบได้หลายรูป) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Attach Trip Photos (Multiple allowed)</label>
                        <input type="file" 
                               name="images[]" 
                               multiple 
                               accept="image/*" 
                               @change="handleFiles" 
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                        
                        <!-- Multi-image Preview Grid -->
                        <div x-show="previews.length > 0" class="grid grid-cols-3 gap-2 mt-3">
                            <template x-for="(img, idx) in previews" :key="idx">
                                <div class="relative h-20 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                    <img :src="img" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md shadow-emerald-600/20 text-xs transition">
                        Submit Review
                    </button>
                </form>
            </div>

            <!-- 3. Reviews List (รายการความคิดเห็นทั้งหมด) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <h2 class="text-xl font-extrabold text-slate-900">Recent Reviews</h2>
                    <span class="text-xs text-slate-500 font-medium">Showing {{ $reviews->total() }} reviews</span>
                </div>

                @if($reviews->isEmpty())
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
                        <div class="text-4xl mb-3">💬</div>
                        <h4 class="font-bold text-slate-800 text-base">No reviews yet</h4>
                        <p class="text-xs text-slate-400 mt-1">Be the first traveler to post a review and share trip photos!</p>
                    </div>
                @else
                    @foreach($reviews as $item)
                        <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-100 transition hover:shadow-md">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <!-- User Avatar Icon -->
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $item->is_anonymous ? 'bg-slate-100 text-slate-500' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $item->is_anonymous ? '👤' : strtoupper(substr($item->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                            {{ $item->name }}
                                            @if($item->is_anonymous)
                                                <span class="text-[10px] font-medium bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">Anonymous</span>
                                            @endif
                                        </h4>
                                        <span class="text-[11px] text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <!-- Star Rating Display -->
                                <div class="text-amber-400 text-sm tracking-wider flex">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span>{{ $s <= $item->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>

                            <!-- Comment Message -->
                            <p class="text-slate-700 text-xs sm:text-sm mt-4 leading-relaxed whitespace-pre-line">
                                {{ $item->comment }}
                            </p>

                            <!-- Multi-image Gallery Display -->
                            @if($item->images && $item->images->count() > 0)
                                <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5">
                                    @foreach($item->images as $img)
                                        <a href="{{ asset('storage/' . $img->image) }}" target="_blank" class="block h-28 sm:h-32 rounded-2xl overflow-hidden border border-slate-100 shadow-sm group">
                                            <img src="{{ asset('storage/' . $img->image) }}" 
                                                 alt="Photo by {{ $item->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                        </a>
                                    @endforeach
                                </div>
                            @elseif($item->image)
                                <div class="mt-4">
                                    <a href="{{ asset('storage/' . $item->image) }}" target="_blank" class="block max-w-sm rounded-2xl overflow-hidden border border-slate-100 shadow-sm">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Photo by {{ $item->name }}" class="w-full h-48 object-cover">
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection