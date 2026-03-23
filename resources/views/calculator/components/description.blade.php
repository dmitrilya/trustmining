<div x-data="{ show: false }" class="mt-6 md:mt-0 md:p-6 md:pt-0 lg:p-9 lg:pt-0 xl:p-12 xl:pt-0">
    <h2 class="mb-2 sm:mb-3 font-bold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Profitability analysis overview') }}</h2>

    <div itemprop="description"
        class="ql-editor text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400 transition-all ease-in-out"
        style="overflow-y: hidden; max-height: 3.75rem"
        :style="{ maxHeight: show ? $el.scrollHeight + 'px' : '3.75rem' }">
        @php
            $haveProfits = $selVersion->profits && count($selVersion->profits);
            $income = $haveProfits
                ? ($selVersion->profits[0]['profit'] * (100 - $selVersion->profits[0]['coins'][0]['fee']) * 99.7) /
                    10000
                : 0;
            $expense = ((($selVersion->efficiency * $selVersion->hashrate) / 1000) * 5 * 24 * 99.7) / 100;
            $profitU = ($haveProfits ? $income : 0) - $expense * $rub;
        @endphp
        {{ __('descriptions.calculator.main', [
            'brand' => $selModel->asicBrand->name,
            'model' => $selModel->name,
            'version' => $selVersion->hashrate . $selVersion->measurement,
            'incomeU' => round($income, 2),
            'incomeR' => round($income / $rub, 2),
            'expenseU' => round($expense * $rub, 2),
            'expenseR' => round($expense, 2),
            'profitU' => round($profitU, 2),
            'profitR' => round(($haveProfits ? $income / $rub : 0) - $expense, 2),
            'tariff' => 5,
        ]) }}
        @if ($selVersion->price)
            {{ __('descriptions.calculator.payback.have', [
                'brand' => $selModel->asicBrand->name,
                'model' => $selModel->name,
                'version' => $selVersion->hashrate . $selVersion->measurement,
                'seller' => $selVersion->seller,
                'price' => $selVersion->price,
                'payback' => $profitU > 0 ? round($selVersion->price / $profitU) : '∞',
            ]) }}
        @else
            {{ __('descriptions.calculator.payback.not', [
                'brand' => $selModel->asicBrand->name,
                'model' => $selModel->name,
                'version' => $selVersion->hashrate . $selVersion->measurement,
            ]) }}
            <a href="{{ route('database.asic-miners.model', ['asicBrand' => $selModel->asicBrand->slug, 'asicModel' => $selModel->slug]) }}"
                class="inline text-indigo-500 hover:text-indigo-600">{{ __('Offers') }} {{ $selModel->name }}</a>
        @endif
        {{ __('descriptions.calculator.params', [
            'model' => $selModel->name,
            'version' => $selVersion->hashrate . $selVersion->measurement,
            'efficiency' => $selVersion->efficiency . ' j/' . $selVersion->measurement,
            'power' => $selVersion->efficiency * $selVersion->hashrate,
            'tariff' => 5,
            'coins' => $selModel->algorithm['coins']->pluck('abbreviation')->implode(', '),
            'comission' => $haveProfits ? $selVersion->profits[0]['coins'][0]['fee'] : 0,
            'uptime' => 99.7,
            'algorithm' => $selModel->algorithm->name,
        ]) }}
    </div>

    <button @click="show = !show"
        class="mt-2 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">
        <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
    </button>
</div>
