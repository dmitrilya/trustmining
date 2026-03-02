@props(['type' => 'row'])

@if ($type == 'short')
    <p {{ $attributes->merge(['class' => 'color-logo-gradient font-extrabold w-fit']) }}>ТМ</p>
@else
    <p {{ $attributes->merge(['class' => 'color-logo-gradient font-extrabold w-fit']) }}>ТРАСТМАЙНИНГ</p>
@endif
