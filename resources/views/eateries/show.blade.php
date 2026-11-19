@extends('layouts.app')

@section('title', $eatery->name . " - Kaon Ta! Davao")

@section('content')
@php
    $priceSymbols = [
        'budget' => '₱ (Budget Meal)',
        'mid' => '₱₱ (Mid-range)',
        'splurge' => '₱₱₱ (Splurge)',
    ];
    $isPermitExpired = $eatery->permit && $eatery->permit->expires_on->isPast();
    $sortedReviews = $eatery->reviews->sortByDesc('created_at');
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Top Navigation (in clean English) -->
    <div class="flex items-center justify-between">
        <a href="{{ route('eateries.index') }}" class="text-sm font-extrabold text-red-700 hover:text-red-800 flex items-center gap-1">
            <span>←</span>
            <span>Back to Eateries</span>
        </a>

        <!-- Edit and Delete buttons for the eatery -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('eateries.edit', $eatery) }}" class="px-4 py-2 border-2 border-amber-300 rounded-xl text-sm font-bold text-stone-700 bg-white hover:bg-amber-50 shadow-sm transition">
                Edit Eatery
            </a>

            <form action="{{ route('eateries.destroy', $eatery) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this eatery?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-xl shadow-sm transition">
                    Delete Eatery
                </button>
            </form>
        </div>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-3xl border-2 border-amber-200 p-6 sm:p-8 shadow-md relative overflow-hidden">
        <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-red-600 via-amber-400 to-yellow-400"></div>

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6 pt-2">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight font-fiesta">{{ $eatery->name }}</h1>
                    @if ($eatery->is_open)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                            Open
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-rose-100 text-rose-800 border border-rose-300">
                            Closed
                        </span>
                    @endif
                </div>

                <p class="text-stone-600 text-sm mt-2 flex items-center gap-1.5 flex-wrap">
                    <span>Located in</span>
                    <a href="{{ route('districts.show', $eatery->district) }}" class="text-red-700 font-extrabold hover:underline">
                        {{ $eatery->district->name }}
                    </a>
                    <span>•</span>
                    <span class="text-stone-700 font-medium">{{ $eatery->address }}</span>
                </p>

                <div class="flex items-center space-x-3 mt-3 text-sm">
                    <span class="font-extrabold text-amber-900 bg-amber-100 px-3 py-0.5 rounded-lg border border-amber-200">{{ $priceSymbols[$eatery->price_range] ?? $eatery->price_range }}</span>
                    @if ($eatery->specialty)
                        <span class="text-stone-300">•</span>
                        <span class="text-stone-700">Specialty: <strong class="text-red-800 font-bold">🍲 {{ $eatery->specialty }}</strong></span>
                    @endif
                </div>

                <!-- Average Rating -->
                <div class="mt-4 flex items-center gap-2">
                    @if ($eatery->reviews_avg_rating)
                        <x-rating :value="$eatery->reviews_avg_rating" />
                        <span class="text-red-700 font-black text-lg">{{ number_format((float)$eatery->reviews_avg_rating, 1) }}</span>
                        <span class="text-stone-500 text-sm font-semibold">({{ $eatery->reviews_count }} {{ Str::plural('review', $eatery->reviews_count) }})</span>
                    @else
                        <span class="text-stone-400 text-sm italic">No reviews yet</span>
                    @endif
                </div>
            </div>

            <!-- Business Permit Box -->
            @if ($eatery->permit)
                <div class="bg-amber-50/70 p-5 rounded-2xl border-2 {{ $isPermitExpired ? 'border-rose-400 bg-rose-50/70' : 'border-amber-300' }} sm:max-w-xs w-full text-sm shadow-inner">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="text-base">📜</span>
                        <p class="text-xs font-black uppercase tracking-wider text-amber-950">Davao Business Permit</p>
                    </div>
                    <p class="font-mono font-black text-stone-900 mt-1 text-base">{{ $eatery->permit->permit_no }}</p>
                    <p class="text-xs text-stone-600 mt-1.5">
                        Expires: 
                        <span class="{{ $isPermitExpired ? 'font-black text-rose-600' : 'font-bold text-stone-800' }}">
                            {{ $eatery->permit->expires_on->format('F d, Y') }}
                        </span>
                    </p>
                    @if ($isPermitExpired)
                        <div class="mt-2.5 inline-block px-2.5 py-1 bg-rose-600 text-white font-black text-[11px] rounded-lg uppercase tracking-wider shadow-sm">
                            Permit expired
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Features -->
        @if ($eatery->features->isNotEmpty())
            <div class="mt-6 pt-6 border-t-2 border-amber-100">
                <p class="text-xs font-black uppercase tracking-wider text-amber-950 mb-2.5 flex items-center gap-1">
                    <span>✨</span>
                    <span>Features & Highlights</span>
                </p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($eatery->features as $feature)
                        <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                           class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold {{ $feature->name === 'Suki ni Hisu-an' ? 'bg-yellow-300 text-red-950 border-2 border-yellow-400 shadow-sm' : 'bg-stone-100 text-stone-700 hover:bg-amber-100 border border-stone-200' }} transition">
                            @if ($feature->name === 'Suki ni Hisu-an') ⭐ @endif
                            {{ $feature->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Dishes List -->
    <div class="bg-white rounded-3xl border-2 border-amber-200 p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-2xl">🍲</span>
            <h2 class="text-2xl font-black text-stone-900 tracking-tight font-fiesta">Featured Dishes & Menu</h2>
        </div>

        @if ($eatery->dishes->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($eatery->dishes as $dish)
                    <div class="p-4 rounded-2xl border-2 border-amber-100 bg-gradient-to-r from-amber-50/40 to-yellow-50/30 flex items-center justify-between hover:border-amber-300 transition">
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-extrabold text-stone-900 text-sm sm:text-base">{{ $dish->name }}</h4>
                                @if ($dish->is_bestseller)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black bg-gradient-to-r from-red-600 to-amber-500 text-yellow-100 uppercase tracking-wider shadow-sm">
                                        🔥 Bestseller
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="font-black text-red-700 text-base">₱{{ number_format((float)$dish->price, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-stone-500 italic">No menu items listed yet.</p>
        @endif
    </div>

    <!-- Reviews Section -->
    <div class="space-y-6">
        <div class="flex items-center justify-between border-b-2 border-amber-200 pb-3">
            <div class="flex items-center gap-2">
                <span class="text-2xl">💬</span>
                <div>
                    <h2 class="text-2xl font-black text-stone-900 tracking-tight font-fiesta">Customer Reviews</h2>
                    <p class="text-stone-500 text-xs sm:text-sm">Authentic feedback from Davao residents and visitors.</p>
                </div>
            </div>
            <span class="text-sm font-black text-amber-900 bg-amber-100 px-3 py-1 rounded-full border border-amber-200">
                {{ $eatery->reviews->count() }} {{ Str::plural('review', $eatery->reviews->count()) }}
            </span>
        </div>

        <!-- Add Review Form (If eatery is open) OR Paused notice (If eatery is closed) -->
        @if ($eatery->is_open)
            <div class="bg-white rounded-3xl border-2 border-amber-200 p-6 sm:p-8 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-amber-500 to-red-500"></div>

                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xl">✍️</span>
                    <h3 class="text-lg font-black text-stone-900 font-fiesta">Leave a Review</h3>
                </div>

                <form action="{{ route('eateries.reviews.store', $eatery) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Reviewer Select Field -->
                        <div>
                            <label for="user_id" class="block text-xs font-black uppercase tracking-wider text-amber-950 mb-1">Reviewer *</label>
                            <select name="user_id" id="user_id" required class="w-full px-3.5 py-2.5 border {{ $errors->has('user_id') ? 'border-rose-500' : 'border-amber-300' }} rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                                <option value="">-- Select Reviewer --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-xs text-rose-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rating Select -->
                        <div>
                            <label for="rating" class="block text-xs font-black uppercase tracking-wider text-amber-950 mb-1">Rating *</label>
                            <select name="rating" id="rating" required class="w-full px-3.5 py-2.5 border {{ $errors->has('rating') ? 'border-rose-500' : 'border-amber-300' }} rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                                <option value="">-- Select Star Rating --</option>
                                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>★★★★★ (5 Stars - Lami Kaayo! Balik-balikan)</option>
                                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>★★★★☆ (4 Stars - Very Good)</option>
                                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>★★★☆☆ (3 Stars - Average)</option>
                                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>★★☆☆☆ (2 Stars - Below Average)</option>
                                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>★☆☆☆☆ (1 Star - Poor)</option>
                            </select>
                            @error('rating')
                                <p class="mt-1 text-xs text-rose-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Review Body -->
                    <div>
                        <label for="body" class="block text-xs font-black uppercase tracking-wider text-amber-950 mb-1">Your Review Feedback *</label>
                        <textarea name="body" id="body" rows="3" required
                                  class="w-full px-3.5 py-2.5 border {{ $errors->has('body') ? 'border-rose-500' : 'border-amber-300' }} rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none"
                                  placeholder="Share your experience about food taste, pricing, and service...">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-1 text-xs text-rose-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-700 hover:to-amber-700 text-yellow-200 font-black text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5 border border-yellow-300">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-gradient-to-r from-rose-100 to-red-100 border-2 border-rose-300 rounded-3xl p-6 text-center shadow-inner">
                <span class="text-3xl block mb-1">🛑</span>
                <p class="text-rose-900 font-black text-lg">This eatery is closed. Reviews are paused.</p>
                <p class="text-rose-700 text-xs mt-1">This eatery is currently closed.</p>
            </div>
        @endif

        <!-- Reviews List (Newest first) -->
        @if ($sortedReviews->isNotEmpty())
            <div class="space-y-4">
                @foreach ($sortedReviews as $review)
                    <div class="bg-white rounded-2xl border-2 border-amber-100 p-5 shadow-sm hover:border-amber-200 transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base">👤</span>
                                    <a href="{{ route('reviewers.show', $review->user) }}" class="font-extrabold text-stone-900 hover:text-red-700 transition">
                                        {{ $review->user->name }}
                                    </a>
                                    <span class="text-xs text-stone-400">• {{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="mt-1.5 flex items-center gap-1">
                                    <x-rating :value="$review->rating" />
                                </div>
                            </div>

                            <!-- Delete button for review in English -->
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-bold px-2 py-1 hover:bg-rose-50 rounded-lg transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                        <p class="text-stone-700 text-sm mt-3 leading-relaxed bg-amber-50/40 p-3 rounded-xl border border-amber-100">{{ $review->body }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl border-2 border-amber-200 p-8 text-center text-stone-500">
                <p>No reviews yet for {{ $eatery->name }}. Be the first to review!</p>
            </div>
        @endif
    </div>
</div>
@endsection
