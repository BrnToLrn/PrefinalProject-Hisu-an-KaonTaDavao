<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <!-- Page Title & Subtitle with Fiesta Styling -->
        <div class="border-b-2 border-amber-200 pb-5">
            <div class="flex items-center gap-2">
                <span class="text-3xl">🍲</span>
                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight font-fiesta">Davao Eateries</h1>
            </div>
            <p class="text-stone-600 text-sm mt-1">Discover popular local carinderias, stalls, and dining spots across Davao City.</p>
        </div>

        <!-- Filter Form with Karinderya Palette -->
        <div class="bg-white rounded-2xl shadow-sm border-2 border-amber-200 p-5 sm:p-6 relative overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-red-500 via-amber-400 to-yellow-400"></div>

            <form action="{{ route('eateries.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search term q -->
                <div class="md:col-span-1">
                    <label for="q" class="block text-xs font-black uppercase tracking-wider text-amber-900 mb-1.5 flex items-center gap-1">
                        <span>🔍</span>
                        <span>Search</span>
                    </label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Search name or specialty..."
                           class="w-full px-3.5 py-2.5 border border-amber-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none bg-amber-50/30">
                </div>

                <!-- District select -->
                <div class="md:col-span-1">
                    <label for="district" class="block text-xs font-black uppercase tracking-wider text-amber-900 mb-1.5 flex items-center gap-1">
                        <span>📍</span>
                        <span>District</span>
                    </label>
                    <select name="district" id="district" class="w-full px-3.5 py-2.5 border border-amber-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                        <option value="">All Districts</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district') == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Feature select -->
                <div class="md:col-span-1">
                    <label for="feature" class="block text-xs font-black uppercase tracking-wider text-amber-900 mb-1.5 flex items-center gap-1">
                        <span>🏷️</span>
                        <span>Feature Tag</span>
                    </label>
                    <select name="feature" id="feature" class="w-full px-3.5 py-2.5 border border-amber-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                        <option value="">All Features</option>
                        @foreach ($features as $feature)
                            <option value="{{ $feature->name }}" {{ request('feature') == $feature->name ? 'selected' : '' }}>
                                {{ $feature->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions in English -->
                <div class="md:col-span-1 flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-yellow-200 font-black text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'district', 'feature']))
                        <a href="{{ route('eateries.index') }}" class="px-3.5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-bold rounded-xl transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Responsive Eatery Cards Grid: 1 col on phones, 2 on tablets, 3 on desktop -->
        @if ($eateries->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($eateries as $eatery)
                    <x-eatery-card :eatery="$eatery" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pt-6">
                {{ $eateries->links() }}
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm border-2 border-amber-300 p-12 text-center">
                <div class="text-5xl mb-3">🍽️</div>
                <h3 class="text-xl font-black text-stone-800 font-fiesta">No eateries match your filters.</h3>
                <p class="text-stone-500 text-sm mt-1.5">Try clearing some filter fields or search for other specialties.</p>
                <div class="mt-5">
                    <a href="{{ route('eateries.index') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-sm rounded-xl transition shadow">
                        <span>View All Eateries</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
