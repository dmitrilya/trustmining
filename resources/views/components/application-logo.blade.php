@props(['type' => 'row', 'lang' => 'ru'])

@if ($type == 'short')
    <p {{ $attributes->merge(['class' => 'color-logo-gradient font-extrabold w-fit']) }}>{{ $lang == 'ru' ? 'ТМ' : 'TM' }}</p>
@else
    <p {{ $attributes->merge(['class' => 'color-logo-gradient font-extrabold w-fit']) }}>{{ $lang == 'ru' ? 'ТРАСТМАЙНИНГ' : 'TRUSTMINING' }}</p>
@endif
