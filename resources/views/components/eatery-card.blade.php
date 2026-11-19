@props(['eatery'])

@php
    $priceSymbols = [
        'budget' => '₱',
        'mid' => '₱₱',
        'splurge' => '₱₱₱',
    ];
    $displayPrice = $priceSymbols[$eatery->price_range] ?? $eatery->price_range;
    $avgRating = $eatery->reviews_avg_rating ? number_format((float)$eatery->reviews_avg_rating, 1) : null;
    $reviewCount = $eatery->reviews_count ?? $eatery->reviews->count();
@endphp

<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg border-2 border-amber-200/80 overflow-hidden transition-all duration-200 transform hover:-translate-y-1 flex flex-col justify-between p-5 relative group">
    <!-- Top banner accent -->
    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-red-500 via-amber-400 to-yellow-400"></div>

    <div>
        <div class="flex items-start justify-between gap-2 mb-2 pt-1">
            <h3 class="text-lg font-black text-stone-900 group-hover:text-red-700 transition">
                <a href="{{ route('eateries.show', $eatery) }}">
                    {{ $eatery->name }}
                </a>
            </h3>
            @if (!$eatery->is_open)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-100 text-rose-800 border border-rose-200 shadow-sm">
                    Closed
                </span>
            @else
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                    Bukas
                </span>
            @endif
        </div>

        <div class="text-xs text-stone-600 mb-2.5 flex items-center gap-2 flex-wrap">
            <a href="{{ route('districts.show', $eatery->district) }}" class="font-bold text-red-700 hover:underline inline-flex items-center gap-1">
                <span>📍</span>
                <span>{{ $eatery->district->name }}</span>
            </a>
            <span class="text-stone-300">•</span>
            <span class="font-extrabold text-amber-900 bg-amber-100 px-2.5 py-0.5 rounded-lg border border-amber-200">{{ $displayPrice }}</span>
            @if ($eatery->specialty)
                <span class="text-stone-300">•</span>
                <span class="italic text-stone-700 font-medium truncate max-w-[170px]" title="{{ $eatery->specialty }}">🍲 {{ $eatery->specialty }}</span>
            @endif
        </div>

        <!-- Rating with component -->
        <div class="flex items-center space-x-1.5 mb-3 text-sm">
            @if ($avgRating)
                <x-rating :value="$eatery->reviews_avg_rating" />
                <span class="text-red-700 font-black ml-1">{{ $avgRating }}</span>
                <span class="text-stone-400 text-xs">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
            @else
                <span class="text-stone-400 text-xs italic">No reviews yet</span>
            @endif
        </div>

        <!-- Features Badges -->
        @if ($eatery->features->isNotEmpty())
            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach ($eatery->features as $feature)
                    <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}" 
                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $feature->name === 'Suki ni Hisu-an' ? 'bg-yellow-300 text-red-950 border-2 border-yellow-400 shadow-sm' : 'bg-stone-100 text-stone-700 hover:bg-amber-100 border border-stone-200' }} transition">
                        @if ($feature->name === 'Suki ni Hisu-an') ⭐ @endif
                        {{ $feature->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="pt-3 border-t border-amber-100 flex items-center justify-between text-xs">
        <span class="text-stone-500 truncate max-w-[200px]" title="{{ $eatery->address }}">{{ $eatery->address }}</span>
        <a href="{{ route('eateries.show', $eatery) }}" class="text-red-700 font-black hover:text-red-800 flex items-center gap-1 group-hover:translate-x-0.5 transition">
            View Details →
        </a>
    </div>
</div>
