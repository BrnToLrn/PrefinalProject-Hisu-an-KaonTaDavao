<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <div>
            <a href="{{ route('eateries.index') }}" class="text-sm font-extrabold text-red-700 hover:text-red-800 flex items-center gap-1">
                <span>←</span>
                <span>Back to Eateries</span>
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-3 border-b-2 border-amber-200 pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-3xl">👤</span>
                    <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight font-fiesta">
                        {{ $reviewer->name }}
                    </h1>
                </div>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-yellow-300 text-red-950 border border-yellow-400 shadow-sm">
                    {{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }} written
                </span>
            </div>
            <p class="text-stone-600 text-sm mt-2">
                {{ $reviewer->email }} • Kaon Ta! Davao Community Reviewer
            </p>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <span class="text-2xl">📝</span>
                <h2 class="text-2xl font-black text-stone-900 font-fiesta">Reviews History</h2>
            </div>

            @if ($reviewer->reviews->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($reviewer->reviews as $review)
                        <div class="bg-white rounded-3xl border-2 border-amber-200 p-6 shadow-sm hover:border-amber-300 transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-black text-lg text-stone-900 hover:text-red-700 transition font-fiesta">
                                        <a href="{{ route('eateries.show', $review->eatery) }}">
                                            {{ $review->eatery->name }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <x-rating :value="$review->rating" />
                                        <span class="text-xs text-stone-400">• {{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('eateries.show', $review->eatery) }}" class="text-xs font-black text-red-700 hover:underline flex items-center gap-1">
                                    <span>View Eatery</span>
                                    <span>→</span>
                                </a>
                            </div>
                            <p class="text-stone-700 text-sm mt-3.5 leading-relaxed bg-amber-50/50 p-4 rounded-2xl border border-amber-100">{{ $review->body }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl border-2 border-amber-200 p-10 text-center text-stone-500">
                    <p>{{ $reviewer->name }} has not written any reviews yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
