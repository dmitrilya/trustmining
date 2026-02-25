@props(['type' => 'row'])

@if ($type == 'short')
    <p {{ $attributes->merge(['class' => 'color-logo-gradient font-extrabold w-fit']) }}>TM</p>
@else
    <p {{ $attributes->merge(['class' => 'color-logo-gradient font-extrabold w-fit']) }}>TRUSTMINING</p>
@endif
