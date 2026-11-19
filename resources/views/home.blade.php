<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        <!-- Festive Fiesta Hero Banner -->
        <div class="relative overflow-hidden bg-gradient-to-br from-red-600 via-amber-600 to-yellow-500 rounded-3xl shadow-xl p-8 sm:p-14 text-white border-4 border-yellow-300">
            <!-- Decorative celebratory backdrop motifs -->
            <div class="absolute -right-10 -bottom-10 text-9xl opacity-20 pointer-events-none select-none">
                🍲
            </div>
            <div class="absolute top-3 right-6 text-4xl opacity-30 pointer-events-none select-none">
                🏮
            </div>

            <div class="relative z-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-yellow-400 text-red-950 rounded-full text-xs font-black uppercase tracking-wider mb-4 shadow-sm border border-yellow-200">
                    <span>🎉</span>
                    <span>Davao City Fiesta Food & Carinderia Guide</span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-black tracking-tight mb-4 drop-shadow font-fiesta">
                    Kaon Ta! Davao
                </h1>

                <p class="text-amber-100 text-lg sm:text-xl font-medium leading-relaxed drop-shadow-sm">
                    Discover Davao City's vibrant carinderia culture — steaming tinola in Poblacion, fresh tuna kinilaw in Agdao, authentic halal cuisines, and refreshing durian shakes!
                </p>

                <!-- Three Counts Section -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 pt-8 border-t-2 border-yellow-300/40">
                    <div class="bg-red-950/40 backdrop-blur-md rounded-2xl p-5 border border-yellow-300/30 shadow-inner">
                        <div class="flex items-center justify-between">
                            <p class="text-xs uppercase tracking-wider text-yellow-300 font-extrabold">Total Eateries</p>
                            <span class="text-lg">🏪</span>
                        </div>
                        <p class="text-3xl sm:text-4xl font-black mt-1 text-white">{{ $eateriesCount }}</p>
                        <p class="text-[11px] text-amber-200 mt-1">registered dining spots</p>
                    </div>

                    <div class="bg-red-950/40 backdrop-blur-md rounded-2xl p-5 border border-yellow-300/30 shadow-inner">
                        <div class="flex items-center justify-between">
                            <p class="text-xs uppercase tracking-wider text-yellow-300 font-extrabold">Districts Covered</p>
                            <span class="text-lg">📍</span>
                        </div>
                        <p class="text-3xl sm:text-4xl font-black mt-1 text-white">{{ $districtsCount }}</p>
                        <p class="text-[11px] text-amber-200 mt-1">from Poblacion to Toril</p>
                    </div>

                    <div class="bg-red-950/40 backdrop-blur-md rounded-2xl p-5 border border-yellow-300/30 shadow-inner">
                        <div class="flex items-center justify-between">
                            <p class="text-xs uppercase tracking-wider text-yellow-300 font-extrabold">Community Reviews</p>
                            <span class="text-lg">⭐</span>
                        </div>
                        <p class="text-3xl sm:text-4xl font-black mt-1 text-white">{{ $reviewsCount }}</p>
                        <p class="text-[11px] text-amber-200 mt-1">reviews by local residents</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Rated Section -->
        <section class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 border-b-2 border-amber-200 pb-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">🏆</span>
                        <h2 class="text-3xl font-black text-stone-900 tracking-tight font-fiesta">Top Rated</h2>
                    </div>
                    <p class="text-stone-600 text-sm mt-1">The 3 carinderias & eateries with the highest average rating in Davao City.</p>
                </div>
                <a href="{{ route('eateries.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-black text-sm rounded-xl shadow-sm transition">
                    <span>Browse All Eateries</span>
                    <span>→</span>
                </a>
            </div>

            @if ($topEateries->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($topEateries as $eatery)
                        <x-eatery-card :eatery="$eatery" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border-2 border-dashed border-amber-300 text-stone-500">
                    <p class="text-lg">No rated eateries found yet.</p>
                </div>
            @endif
        </section>

        <!-- Quick Links / Festive District Explorer -->
        <section class="bg-gradient-to-r from-amber-100 via-yellow-100 to-orange-100 border-2 border-amber-300 rounded-3xl p-6 sm:p-10 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-3xl">🎋</span>
                <h2 class="text-2xl font-black text-stone-900 font-fiesta">Explore Davao by District</h2>
            </div>
            <p class="text-stone-700 text-sm mb-6 max-w-2xl leading-relaxed">
                Take a food crawl through Davao! Pick a district to view all local carinderias, grilled seafood spots, and budget dining gems.
            </p>
            <div>
                <a href="{{ route('districts.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-red-700 hover:bg-red-800 text-yellow-300 font-black text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5 border border-yellow-400">
                    <span>View All Districts</span>
                    <span>→</span>
                </a>
            </div>
        </section>
    </div>
</x-app-layout>
