@props(['type' => 'row'])

@if ($type == 'short')
    <div style="font-family: 'Huninn'" {{ $attributes->merge(['class' => 'font-bold drop-shadow-md']) }}><span class="color-secondary-gradient">T</span><span class="color-primary-gradient">M</span></div>
@else
    <div style="font-family: 'Huninn'" {{ $attributes->merge(['class' => 'font-bold drop-shadow-md']) }}><span class="color-secondary-gradient">TRUST</span><span class="color-primary-gradient">MINING</span></div>
@endif
