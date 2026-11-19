<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <div>
            <a href="{{ route('districts.index') }}" class="text-sm font-extrabold text-red-700 hover:text-red-800 flex items-center gap-1">
                <span>←</span>
                <span>Back to Districts</span>
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-3 border-b-2 border-amber-200 pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-3xl">📍</span>
                    <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight font-fiesta">
                        {{ $district->name }}
                    </h1>
                </div>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-yellow-300 text-red-950 border border-yellow-400 shadow-sm">
                    {{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }} in {{ $district->name }}
                </span>
            </div>
            <p class="text-stone-600 text-sm mt-2">
                Showing all carinderias and eateries operating in {{ $district->name }}.
            </p>
        </div>

        @if ($district->eateries->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($district->eateries as $eatery)
                    <x-eatery-card :eatery="$eatery" />
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm border-2 border-amber-300 p-12 text-center text-stone-500">
                <span class="text-4xl block mb-2">🍽️</span>
                <p>No eateries currently listed in {{ $district->name }}.</p>
            </div>
        @endif
    </div>
</x-app-layout>
