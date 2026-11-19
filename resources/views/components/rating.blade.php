@props(['value' => 0, 'max' => 5])

@php
    $rounded = round((float) $value);
@endphp

<span class="inline-flex items-center text-amber-500 font-bold" title="{{ $value }} stars">
@for ($i = 1; $i <= $max; $i++)
@if ($i <= $rounded)
<span>★</span>
@else
<span class="text-stone-300">★</span>
@endif
@endfor
</span>
