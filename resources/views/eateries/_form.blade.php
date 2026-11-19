@csrf

@php
    $selectedFeatures = old('features', isset($eatery) && $eatery->exists ? $eatery->features->pluck('id')->toArray() : []);
    $isOpen = old('is_open', isset($eatery) && $eatery->exists ? $eatery->is_open : true);
@endphp

<div class="space-y-6">
    <!-- Eatery Name -->
    <div>
        <label for="name" class="block text-sm font-bold text-stone-700 mb-1">Eatery Name *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $eatery->name ?? '') }}" maxlength="100"
               class="w-full px-4 py-2 border @error('name') border-rose-500 @else border-stone-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none"
               placeholder="e.g. Carinderia ni Hisu-an">
        @error('name')
            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- District Selection -->
    <div>
        <label for="district_id" class="block text-sm font-bold text-stone-700 mb-1">District *</label>
        <select name="district_id" id="district_id"
                class="w-full px-4 py-2 border @error('district_id') border-rose-500 @else border-stone-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
            <option value="">-- Select Davao District --</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(old('district_id', $eatery->district_id ?? '') == $district->id)>
                    {{ $district->name }}
                </option>
            @endforeach
        </select>
        @error('district_id')
            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Address -->
    <div>
        <label for="address" class="block text-sm font-bold text-stone-700 mb-1">Address *</label>
        <input type="text" name="address" id="address" value="{{ old('address', $eatery->address ?? '') }}"
               class="w-full px-4 py-2 border @error('address') border-rose-500 @else border-stone-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none"
               placeholder="Street name, Barangay, Davao City">
        @error('address')
            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Price Range -->
        <div>
            <label for="price_range" class="block text-sm font-bold text-stone-700 mb-1">Price Range *</label>
            <select name="price_range" id="price_range"
                    class="w-full px-4 py-2 border @error('price_range') border-rose-500 @else border-stone-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none bg-white">
                <option value="">-- Select Price Range --</option>
                <option value="budget" @selected(old('price_range', $eatery->price_range ?? '') === 'budget')>Budget (₱)</option>
                <option value="mid" @selected(old('price_range', $eatery->price_range ?? '') === 'mid')>Mid-range (₱₱)</option>
                <option value="splurge" @selected(old('price_range', $eatery->price_range ?? '') === 'splurge')>Splurge (₱₱₱)</option>
            </select>
            @error('price_range')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Specialty -->
        <div>
            <label for="specialty" class="block text-sm font-bold text-stone-700 mb-1">Specialty</label>
            <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $eatery->specialty ?? '') }}" maxlength="100"
                   class="w-full px-4 py-2 border @error('specialty') border-rose-500 @else border-stone-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none"
                   placeholder="e.g. Tuna Kinilaw, Beef Bulalo">
            @error('specialty')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Business Permit Box -->
    <div class="p-4 bg-stone-50 rounded-xl border border-stone-200 space-y-4">
        <h4 class="text-sm font-extrabold uppercase tracking-wider text-stone-700">Davao Business Permit Details</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="permit_no" class="block text-xs font-bold text-stone-600 mb-1">Permit Number *</label>
                <input type="text" name="permit_no" id="permit_no" value="{{ old('permit_no', $eatery->permit->permit_no ?? '') }}"
                       class="w-full px-3 py-2 border @error('permit_no') border-rose-500 @else border-stone-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none"
                       placeholder="e.g. DVO-2026-0202">
                @error('permit_no')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="expires_on" class="block text-xs font-bold text-stone-600 mb-1">Permit Expiry Date *</label>
                <input type="date" name="expires_on" id="expires_on" value="{{ old('expires_on', isset($eatery->permit) && $eatery->permit->expires_on ? $eatery->permit->expires_on->format('Y-m-d') : '') }}"
                       class="w-full px-3 py-2 border @error('expires_on') border-rose-500 @else border-stone-300 @enderror rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                @error('expires_on')
                    <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Features (Checkboxes) -->
    <div>
        <label class="block text-sm font-bold text-stone-700 mb-2">Features & Amenities *</label>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @foreach ($features as $feature)
                <label class="inline-flex items-center space-x-2 text-sm text-stone-700 bg-white p-2.5 rounded-lg border border-stone-200 cursor-pointer hover:bg-stone-50 transition">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                           @checked(in_array($feature->id, (array)$selectedFeatures))
                           class="rounded text-amber-600 focus:ring-amber-500 h-4 w-4">
                    <span class="{{ $feature->name === 'Suki ni Hisu-an' ? 'font-bold text-amber-800' : '' }}">{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <!-- Is Open Checkbox -->
    <div class="pt-2">
        <label class="inline-flex items-center space-x-2 cursor-pointer">
            <input type="hidden" name="is_open" value="0">
            <input type="checkbox" name="is_open" value="1" @checked($isOpen)
                   class="rounded text-amber-600 focus:ring-amber-500 h-5 w-5">
            <span class="text-sm font-bold text-stone-800">Currently Open for Customers</span>
        </label>
        <p class="text-xs text-stone-500 ml-7">Unchecking this marks the eatery as Closed and pauses new customer reviews.</p>
    </div>
</div>
