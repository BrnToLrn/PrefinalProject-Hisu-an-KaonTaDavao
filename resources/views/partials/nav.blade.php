<header class="relative bg-gradient-to-r from-red-700 via-amber-600 to-yellow-500 text-white shadow-lg sticky top-0 z-50">
    <!-- Festive Banderitas (Fiesta Bunting Pennants) Banner -->
    <div class="h-2.5 w-full bg-repeat-x flex overflow-hidden opacity-95 select-none" style="background-image: repeating-linear-gradient(45deg, #ef4444 0, #ef4444 15px, #f59e0b 15px, #f59e0b 30px, #10b981 30px, #10b981 45px, #3b82f6 45px, #3b82f6 60px);"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <!-- Brand / Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="group flex items-center space-x-2.5 transition transform hover:scale-[1.02]">
                    <div class="bg-yellow-300 text-red-800 p-2 rounded-xl shadow-md border-2 border-yellow-100 flex items-center justify-center font-black text-xl tracking-tighter">
                        🍲
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl sm:text-2xl font-black tracking-tight drop-shadow-sm font-serif">
                                Kaon Ta! Davao
                            </span>
                            <span class="bg-yellow-400 text-red-950 text-[10px] uppercase font-extrabold px-2 py-0.5 rounded-full shadow-sm">
                                Food Guide
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-amber-100 font-medium tracking-wide">
                            Hisu-an's Davao Carinderia & Food Guide
                        </p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links (in clean English) -->
            <nav class="flex items-center space-x-1 sm:space-x-3 text-sm font-bold">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('home') ? 'bg-red-800/80 text-yellow-300 shadow-inner' : 'text-amber-50 hover:bg-white/15' }}">
                    Home
                </a>
                <a href="{{ route('eateries.index') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('eateries.*') && !request()->routeIs('eateries.create') ? 'bg-red-800/80 text-yellow-300 shadow-inner' : 'text-amber-50 hover:bg-white/15' }}">
                    Eateries
                </a>
                <a href="{{ route('districts.index') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('districts.*') ? 'bg-red-800/80 text-yellow-300 shadow-inner' : 'text-amber-50 hover:bg-white/15' }}">
                    Districts
                </a>
                <a href="{{ route('eateries.create') }}" class="ml-2 inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-red-900 font-black rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 border border-yellow-200">
                    <span>+</span>
                    <span>Add Eatery</span>
                </a>
            </nav>
        </div>
    </div>
</header>
