<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Kaon Ta! Davao - Hisu-an's Food Guide" }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-fiesta {
            font-family: 'Playfair Display', serif;
        }
        /* Festive background subtle warm texture */
        .bg-fiesta-pattern {
            background-color: #faf7f2;
            background-image: radial-gradient(#fbbf24 0.65px, transparent 0.65px), radial-gradient(#ef4444 0.65px, #faf7f2 0.65px);
            background-size: 26px 26px;
            background-position: 0 0, 13px 13px;
        }
    </style>
</head>
<body class="bg-fiesta-pattern text-stone-800 min-h-screen flex flex-col antialiased selection:bg-amber-400 selection:text-red-950">
    <!-- Navbar partial -->
    @include('partials.nav')

    <!-- Flash notifications partial -->
    @include('partials.flash')

    <!-- Main Content -->
    <main class="flex-grow">
        @if (isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Festive Footer -->
    <footer class="bg-gradient-to-b from-stone-900 to-amber-950 text-stone-300 py-10 border-t-4 border-yellow-500 mt-16 relative overflow-hidden">
        <!-- Decorative banderitas strip at footer top -->
        <div class="absolute top-0 inset-x-0 h-1.5 bg-repeat-x opacity-80" style="background-image: repeating-linear-gradient(45deg, #ef4444 0, #ef4444 10px, #f59e0b 10px, #f59e0b 20px, #10b981 20px, #10b981 30px, #3b82f6 30px, #3b82f6 40px);"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-sm gap-4">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">🎉</span>
                <div>
                    <p class="font-extrabold text-amber-200 text-base">Kaon Ta! Davao - Hisu-an's Food Guide</p>
                    <p class="text-xs text-stone-400 mt-0.5">Davao City Tourism Office project • Pahalipay sa Kalingawan ug Pagkaon</p>
                </div>
            </div>
            <div class="text-right sm:text-right text-stone-400 text-xs sm:text-sm">
                <p>Curated with ❤️ by <span class="text-yellow-400 font-bold">Al Franzianne Hisu-an</span></p>
                <p class="text-[11px] text-stone-500 mt-0.5">Mangaon ta ninyo sa Davao! Halin og Lami.</p>
            </div>
        </div>
    </footer>
</body>
</html>
