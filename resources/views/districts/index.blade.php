<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <div class="border-b-2 border-amber-200 pb-4">
            <div class="flex items-center gap-2">
                <span class="text-3xl">📍</span>
                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight font-fiesta">Davao City Districts</h1>
            </div>
            <p class="text-stone-600 text-sm mt-1">Explore dining options grouped across key districts of Davao.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($districts as $district)
                <div class="bg-white rounded-3xl border-2 border-amber-200/90 p-6 shadow-sm hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-red-600 to-yellow-400"></div>

                    <div>
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-black text-stone-900 group-hover:text-red-700 transition font-fiesta">
                                <a href="{{ route('districts.show', $district) }}">
                                    {{ $district->name }}
                                </a>
                            </h2>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-yellow-300 text-red-950 border border-yellow-400 shadow-sm">
                                {{ $district->eateries_count }} {{ Str::plural('eatery', $district->eateries_count) }}
                            </span>
                        </div>
                        <p class="text-stone-600 text-sm mt-3 leading-relaxed">
                            Browse culinary highlights, carinderias, and neighborhood food hubs in {{ $district->name }}.
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-amber-100">
                        <a href="{{ route('districts.show', $district) }}" class="text-sm font-extrabold text-red-700 hover:text-red-800 flex items-center justify-between group-hover:translate-x-0.5 transition">
                            <span>View Eateries in {{ $district->name }}</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
