@props(['name', 'value', 'itemprop' => null, 'unit' => null])

<li @if ($itemprop) itemprop="{{ $itemprop }}" itemscope itemtype="{{ $itemprop == 'additionalProperty' ? 'http://schema.org/PropertyValue' : 'http://schema.org/QuantitativeValue' }}" @endif
    class="flex justify-between items-end text-xs sm:text-sm text-slate-500 dark:text-slate-400">
    <span
        @if ($itemprop) itemprop="{{ $itemprop == 'additionalProperty' ? 'name' : 'valueReference' }}" @endif>{{ __($name) }}</span>
    <span class="dots mx-2"></span>
    @if (!is_array($value))
        <span @if ($itemprop) itemprop="value" @endif
            class="text-slate-700 dark:text-slate-300">{{ __($value) }}</span>
    @else
        <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
            @foreach ($value as $item)
                <div
                    class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs sm:text-xs">
                    {{ $item }}
                </div>
            @endforeach
        </div>
    @endif
    @if ($unit)
        <meta itemprop="{{ $unit['prop'] }}" content="{{ $unit['content'] }}" />
        <span>&nbsp;{{ __($unit['content']) }}</span>
    @endif
</li>
