@props(['blocks' => ['additional-params', 'coins', 'characteristics', 'currency'], 'widjet' => false, 'tariffs' => []])

<div class="{{ !$widjet ? 'min-h-[990px] md:min-h-[660px]' : '' }}">
    <meta itemprop="name" content="{{ __('Income calculator') }} {{ $selModel['b'] }} {{ $selModel['n'] }} {{ $selVersion['h'] }}{{ $selVersion['m'] }}" />
    <meta itemprop="description"
        content="{{ __('Calculate revenue, expenses, profit, and ROI for an ASIC miner') }} {{ $selModel['b'] }} {{ $selModel['n'] }} {{ $selVersion['h'] }}{{ $selVersion['m'] }} {{ __('in a convenient mining calculator') }}" />

    <div itemprop="object" itemscope itemtype="https://schema.org/Product" class="md:grid grid-cols-5 gap-6 lg:gap-8 md:p-2 lg:p-4" x-data="calculator({{ $widjet ? 'true' : 'false' }}, {{ $algorithms }}, {{ $firmwares->values() }}, {{ collect($tariffs) }}, {{ collect($selVersion) }}, {{ collect($selModel) }}, {{ $fee }}, {{ !$widjet ? 'true' : 'false' }}, {{ !$rModel ? 'true' : 'false' }}, {{ $rub }}, { 'With VAT': '{{ __('With VAT') }}', 'Equipment amortization': '{{ __('Equipment amortization') }}', 'Price': '{{ __('Price') }}', 'y': '{{ __('y') }}', 'Tax base': '{{ __('Tax base') }}', 'You will be able to carry forward losses to the next period of up to 10 years': '{{ __('You will be able to carry forward losses to the next period of up to 10 years') }}', 'Your losses are lost. You cannot carry them over to the next period': '{{ __('Your losses are lost. You cannot carry them over to the next period') }}', 'Tax rate': '{{ __('Tax rate') }}', 'Progressive scale': '{{ __('Progressive scale') }}', 'per year': '{{ __('per year') }}', 'Days': ['{{ trans_choice('time.days', 1) }}', '{{ trans_choice('time.days', 2) }}', '{{ trans_choice('time.days', 5) }}'], 'No data': '{{ __('No data') }}' })">
        <div class="col-span-2">
            @include('calculator.components.schema')

            @include('calculator.components.selectversion')

            @include('calculator.components.settings')

            @if (in_array('characteristics', $blocks))
                <div class="hidden md:block">
                    @include('calculator.components.characteristics')
                </div>
            @endif
        </div>

        <div class="mt-4 md:mt-0 md:border-l border-slate-300 dark:border-slate-700 md:pl-6 lg:pl-8 col-span-3">
            @if (in_array('currency', $blocks))
                @include('calculator.components.currency')
            @endif

            @include('calculator.components.profit')

            @if (!$widjet)
                <div class="text-xxs text-slate-500 mt-3">
                    *{{ __('The data is current at the time of calculation. The cryptocurrency market is volatile, and figures are subject to change') }}
                </div>
                <div class="flex text-xs xs:text-sm text-slate-600 dark:text-slate-400 mt-6 sm:mt-7 lg:mt-8">
                    <h3>{{ __('Payback period') }}</h3>:
                    <span class="ml-1 text-slate-800 dark:text-slate-200 font-bold" x-text="paybackPeriod"></span>
                </div>
                <template x-if="minPriceUSDT">
                    <div class="text-xxs text-slate-500 mt-2">
                        *{{ __('The best offer is used for payback and taxes calculation') }} (<span class="text-slate-800 dark:text-slate-200"
                            x-text="Math.round(minPriceUSDT / (currency == 'RUB' ? {{ $rub }} : 1)) + (currency == 'RUB' ? ' ₽' : ' USDT')"></span>)
                    </div>
                </template>
            @endif

            <template x-if="version !== null">
                <div>
                    @if (in_array('coins', $blocks))
                        @include('calculator.components.coins')
                    @endif

                    @if (in_array('characteristics', $blocks))
                        <div class="md:hidden">
                            @include('calculator.components.characteristics')
                        </div>
                    @endif
                </div>
            </template>
        </div>
    </div>
</div>
