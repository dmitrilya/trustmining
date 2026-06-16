<div x-data="{ show: false }" class="mt-6 md:mt-0 md:p-6 md:pt-0 lg:p-9 lg:pt-0 xl:p-12 xl:pt-0">
    <h2 class="mb-2 sm:mb-3 font-bold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Profitability analysis overview') }}</h2>

    <div itemprop="description"
        class="ql-editor text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400 transition-all ease-in-out"
        style="overflow-y: hidden; max-height: 3.75rem"
        :style="{ maxHeight: show ? $el.scrollHeight + 'px' : '3.75rem' }">
        @php
            $haveProfits = count($algorithms[$selVersion['a']]['p']);
            $income = $haveProfits
                ? ($algorithms[$selVersion['a']]['p'][0]['p'] * $selVersion['h'] * $selVersion['c'] * (100 - $fee) * 99.7) /
                    10000
                : 0;
            $expense = ((($selVersion['e'] * $selVersion['h']) / 1000) * 5 * 24 * 99.7) / 100;
            $profitU = ($haveProfits ? $income : 0) - $expense * $rub;
        @endphp
        {{ __('descriptions.calculator.main', [
            'brand' => $selModel['b'],
            'model' => $selModel['n'],
            'version' => $selVersion['h'] . $selVersion['m'],
            'incomeU' => round($income, 2),
            'incomeR' => round($income / $rub, 2),
            'expenseU' => round($expense * $rub, 2),
            'expenseR' => round($expense, 2),
            'profitU' => round($profitU, 2),
            'profitR' => round(($haveProfits ? $income / $rub : 0) - $expense, 2),
            'tariff' => 5,
        ]) }}
        @if ($selVersion['p'])
            {{ __('descriptions.calculator.payback.have', [
                'brand' => $selModel['b'],
                'model' => $selModel['n'],
                'version' => $selVersion['h'] . $selVersion['m'],
                'seller' => $selVersion['s'],
                'price' => $selVersion['p'],
                'payback' => $profitU > 0 ? round($selVersion['p'] / $profitU) : '∞',
            ]) }}
        @else
            {{ __('descriptions.calculator.payback.not', [
                'brand' => $selModel['b'],
                'model' => $selModel['n'],
                'version' => $selVersion['h'] . $selVersion['m'],
            ]) }}
            <a href="{{ route('database.asic-miners.model', ['asicBrand' => $selModel['bs'], 'asicModel' => $selModel['s']]) }}"
                class="inline text-indigo-500 hover:text-indigo-600">{{ __('Offers') }} {{ $selModel['n'] }}</a>
        @endif
        {{ __('descriptions.calculator.params', [
            'model' => $selModel['n'],
            'version' => $selVersion['h'] . $selVersion['m'],
            'efficiency' => $selVersion['e'] . ' j/' . $selVersion['m'],
            'power' => $selVersion['e'] * $selVersion['h'],
            'tariff' => 5,
            'coins' => $coins,
            'comission' => $haveProfits ? $fee : 0,
            'uptime' => 99.7,
            'algorithm' => $algorithm,
        ]) }}
    </div>

    <button @click="show = !show"
        class="mt-2 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">
        <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
    </button>
</div>
