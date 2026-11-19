<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('eateries.index') }}" class="text-sm font-extrabold text-red-700 hover:text-red-800 flex items-center gap-1">
                <span>←</span>
                <span>Back to Eateries</span>
            </a>
            <div class="flex items-center gap-2 mt-2">
                <span class="text-3xl">🍲</span>
                <h1 class="text-3xl sm:text-4xl font-black text-stone-900 tracking-tight font-fiesta">
                    Register New Eatery
                </h1>
            </div>
            <p class="text-stone-600 text-sm mt-1">Add a carinderia, food spot, or local diner to Kaon Ta! Davao.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-md border-2 border-amber-200 p-6 sm:p-10 relative overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-red-600 via-amber-400 to-yellow-400"></div>

            <form action="{{ route('eateries.store') }}" method="POST">
                @include('eateries._form')

                <div class="mt-8 pt-6 border-t-2 border-amber-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('eateries.index') }}" class="px-5 py-2.5 rounded-xl border border-stone-300 text-stone-700 text-sm font-bold hover:bg-stone-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-amber-600 hover:from-red-700 hover:to-amber-700 text-yellow-200 text-sm font-black rounded-xl shadow-md transition transform hover:-translate-y-0.5 border border-yellow-300">
                        Save Eatery
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
