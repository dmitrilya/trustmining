@props(['type' => 'row'])

@if ($type == 'short')
    <img src="img/logo.webp" alt="logo" {{ $attributes->merge(['class' => '']) }}>
@else
    <img src="img/logo-full.webp" alt="logo" {{ $attributes->merge(['class' => '']) }}>
@endif
