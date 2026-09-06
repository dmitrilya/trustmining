<div x-data="{ show: false }" class="mt-6 md:mt-0 md:p-2 md:pt-0 lg:p-4 lg:pt-0">
    <h2 class="mb-2 sm:mb-3 font-extrabold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Profitability analysis overview') }}
    </h2>

    <div itemprop="description" class="ql-editor text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400 transition ease-in-out"
        style="overflow-y: hidden; max-height: 3.75rem" :style="{ maxHeight: show ? $el.scrollHeight + 'px' : '3.75rem' }">

        @php
            $BASE_TARIFF = 5;
            $BASE_UPTIME = 99.7;
            $COEF = ['day' => 1, 'month' => 30, 'year' => 365];
            $BRACKETS = [[50000000, 0.22, 9402000], [20000000, 0.2, 3402000], [5000000, 0.18, 702000], [2400000, 0.15, 312000], [0, 0.13, 0]];
            $taxEnabled = true;
            $taxType = 'ip';
            $isCompany = $taxType === 'ip' || $taxType === 'legal';
            $haveProfits = count($algorithms[$selModel['a']]['p']);
            $algoProfit = $haveProfits ? $algorithms[$selModel['a']]['p'][0]['p'] : 0;
            $hashrate = $selVersion['h'];
            $efficiency = $selVersion['e'];
            $firmwareFee = 0;
            $profit = $algoProfit * $hashrate * $selVersion['c'];
            $dailyIncomeOne = $haveProfits ? ($profit * (100 - $firmwareFee) * (100 - $fee) * $BASE_UPTIME) / 1000000 : 0;
            $dailyConsumptionOne = ((($efficiency * $hashrate) / 1000) * $BASE_TARIFF * 24 * $BASE_UPTIME) / 100;
            $dailyProfitOneUSDT = $dailyIncomeOne - $dailyConsumptionOne * $rub;
            $dailyTax = 0;
            $minPriceUSDT = $selVersion['p'] ? (!$taxEnabled || !empty($selVersion['v']) ? $selVersion['p'] : $selVersion['p'] * 1.2) : null;
            $minPriceRubRounded = $minPriceUSDT ? round($minPriceUSDT / $rub) : null;
            $cryptoTaxProfit = $dailyProfitOneUSDT / $rub;
            $amortization = 0;

            if ($taxEnabled && $isCompany && $minPriceUSDT) {
                $amortization = round($minPriceRubRounded / 1095, 2);
                $cryptoTaxProfit -= $amortization;
            }

            if ($taxEnabled && $cryptoTaxProfit > 0) {
                if ($taxType === 'person' || $taxType === 'ip') {
                    $yearProfit = $cryptoTaxProfit * 365;

                    $matchedBracket = null;

                    foreach ($BRACKETS as $bracket) {
                        if ($yearProfit > $bracket[0]) {
                            $matchedBracket = $bracket;
                            break;
                        }
                    }

                    if ($matchedBracket) {
                        $limitValue = $matchedBracket[0];
                        $rate = $matchedBracket[1];
                        $fixed = $matchedBracket[2];
                        $annualTax = ($yearProfit - $limitValue) * $rate;
                        $annualTaxFixed = $fixed + $annualTax;
                        $dailyTax = $annualTaxFixed / 365;
                    }
                } else {
                    $dailyTax = $cryptoTaxProfit * 0.25;
                }
            }
            $taxU = $dailyTax * $rub;
            $taxR = $dailyTax;
            $taxMonthU = $taxU * $COEF['month'];
            $taxMonthR = $taxR * $COEF['month'];
            $taxYearU = $taxU * $COEF['year'];
            $taxYearR = $taxR * $COEF['year'];
            $profitU = $dailyProfitOneUSDT;
            $profitAfterTaxU = $profitU - $taxU;
            $profitAfterTaxR = $profitAfterTaxU / $rub;
            $profitAfterTaxMonthU = $profitAfterTaxU * $COEF['month'];
            $profitAfterTaxMonthR = $profitAfterTaxR * $COEF['month'];
            $bestFirmware = null;
            $bestFirmwareProfit = null;
            $bestFirmwareUp = 0;

            $availableFirmwares = collect($firmwares)->filter(function ($firmware) use ($selVersion) {
                return $firmware['v'] == $selVersion['i'];
            });

            $baseDailyProfit = $profitU;

            foreach ($availableFirmwares as $firmware) {
                $fwHashrate = $firmware['h'];
                $fwEfficiency = $firmware['e'];
                $fwFee = $firmware['f'];
                $fwProfit = $algoProfit * $fwHashrate * $selVersion['c'];
                $fwDailyIncome = ($fwProfit * (100 - $fwFee) * (100 - $fee) * $BASE_UPTIME) / 1000000;
                $fwDailyConsumption = ((($fwEfficiency * $fwHashrate) / 1000) * $BASE_TARIFF * 24 * $BASE_UPTIME) / 100;
                $fwDailyProfit = $fwDailyIncome - $fwDailyConsumption * $rub;

                if ($taxEnabled && $fwDailyProfit > 0) {
                    $fwCryptoTaxProfit = ($fwDailyIncome - $fwDailyConsumption * $rub) / $rub;

                    if ($isCompany && $minPriceUSDT) {
                        $fwAmortization = round($minPriceRubRounded / 1095, 2);

                        $fwCryptoTaxProfit -= $fwAmortization;
                    }

                    if ($fwCryptoTaxProfit > 0) {
                        $fwDailyTax = 0;

                        if ($taxType === 'person' || $taxType === 'ip') {
                            $fwYearProfit = $fwCryptoTaxProfit * 365;

                            $matchedBracket = null;

                            foreach ($BRACKETS as $bracket) {
                                if ($fwYearProfit > $bracket[0]) {
                                    $matchedBracket = $bracket;
                                    break;
                                }
                            }

                            if ($matchedBracket) {
                                $limitValue = $matchedBracket[0];
                                $rate = $matchedBracket[1];
                                $fixed = $matchedBracket[2];
                                $fwAnnualTax = ($fwYearProfit - $limitValue) * $rate;
                                $fwDailyTax = ($fixed + $fwAnnualTax) / 365;
                            }
                        } else {
                            $fwDailyTax = $fwCryptoTaxProfit * 0.25;
                        }

                        $fwDailyProfit -= $fwDailyTax * $rub;
                    }
                }

                if ($baseDailyProfit > 0 && $fwDailyProfit > $baseDailyProfit) {
                    $up = round((($fwDailyProfit - $baseDailyProfit) / $baseDailyProfit) * 100, 2);
                } elseif ($baseDailyProfit <= 0 && $fwDailyProfit > 0) {
                    $up = 100;
                } else {
                    $up = 0;
                }

                if ($bestFirmware === null || $up > $bestFirmwareUp) {
                    $bestFirmware = $firmware;
                    $bestFirmwareProfit = $fwDailyProfit;
                    $bestFirmwareUp = $up;
                }
            }

            $bestFirmwareName = $bestFirmware['c'] ?? null;
            $bestFirmwareHashrate = $bestFirmware['h'] ?? 0;
            $bestFirmwareUnit = $selVersion['m'];
            $bestFirmwarePower = $bestFirmware ? $bestFirmware['e'] * $bestFirmware['h'] : 0;
            $bestFirmwareEfficiency = $bestFirmware['e'] ?? 0;
            $bestFirmwareProfitU = $bestFirmwareProfit ?? 0;
            $bestFirmwareProfitR = $bestFirmwareProfitU / $rub;
            $bestFirmwareIncreaseU = $bestFirmwareProfitU - $profitAfterTaxU;
            $bestFirmwareIncreaseR = $bestFirmwareIncreaseU / $rub;
            $bestFirmwareIncreasePercent = $profitU > 0 ? ($bestFirmwareIncreaseU / $profitAfterTaxU) * 100 : ($bestFirmwareProfitU > 0 ? 100 : 0);
            $payback = $minPriceUSDT && $profitAfterTaxU > 0 ? round($minPriceUSDT / $profitAfterTaxU) : '∞';
            $paybackAfterTax = $minPriceUSDT && $profitAfterTaxU > 0 ? round($minPriceUSDT / $profitAfterTaxU) : '∞';
        @endphp

        <p>
            {{ __('descriptions.calculator.main', [
                'brand' => $selModel['b'],
                'model' => $selModel['n'],
                'version' => $selVersion['h'] . $selVersion['m'],
                'incomeU' => round($dailyIncomeOne, 2),
                'incomeR' => round($dailyIncomeOne / $rub, 2),
                'expenseU' => round($dailyConsumptionOne * $rub, 2),
                'expenseR' => round($dailyConsumptionOne, 2),
                'profitU' => round($profitU, 2),
                'profitR' => round($profitU / $rub, 2),
                'tariff' => $BASE_TARIFF,
            ]) }}
        </p><br>

        @if ($taxEnabled)
            <p>
                {{ __('descriptions.calculator.tax', [
                    'brand' => $selModel['b'],
                    'model' => $selModel['n'],
                    'version' => $selVersion['h'] . $selVersion['m'],
                    'taxU' => round($taxU, 2),
                    'taxR' => round($taxR, 2),
                    'taxMonthU' => round($taxMonthU, 2),
                    'taxMonthR' => round($taxMonthR, 2),
                    'taxYearU' => round($taxYearU, 2),
                    'taxYearR' => round($taxYearR, 2),
                    'profitAfterTaxU' => round($profitAfterTaxU, 2),
                    'profitAfterTaxR' => round($profitAfterTaxR, 2),
                    'profitAfterTaxMonthU' => round($profitAfterTaxMonthU, 2),
                    'profitAfterTaxMonthR' => round($profitAfterTaxMonthR, 2),
                ]) }}
            </p><br>
        @endif

        <p>
            @if ($minPriceUSDT)
                {{ __('descriptions.calculator.payback.have', [
                    'brand' => $selModel['b'],
                    'model' => $selModel['n'],
                    'version' => $selVersion['h'] . $selVersion['m'],
                    'seller' => $selVersion['s'],
                    'price' => round($minPriceUSDT, 2),
                    'priceR' => round($minPriceUSDT / $rub, 2),
                    'payback' => $payback,
                    'paybackAfterTax' => $paybackAfterTax,
                ]) }}
            @else
                {{ __('descriptions.calculator.payback.not', ['brand' => $selModel['b'], 'model' => $selModel['n'], 'version' => $selVersion['h'] . $selVersion['m']]) }}

                <a href="{{ route('database.asic-miners.model', ['asicBrand' => $selModel['bs'], 'asicModel' => $selModel['s']]) }}"
                    class="inline text-indigo-500 hover:text-indigo-600">
                    {{ __('Offers') }} {{ $selModel['n'] }}
                </a>
            @endif
        </p><br>

        @if ($bestFirmware)
            <p>
                {{ __('descriptions.calculator.firmware', [
                    'brand' => $selModel['b'],
                    'model' => $selModel['n'],
                    'version' => $selVersion['h'] . $selVersion['m'],
                    'firmware' => $bestFirmwareName,
                    'firmwareHashrate' => $bestFirmwareHashrate,
                    'firmwareUnit' => $bestFirmwareUnit,
                    'firmwarePower' => round($bestFirmwarePower),
                    'firmwareEfficiency' => round($bestFirmwareEfficiency, 2),
                    'firmwareProfitU' => round($bestFirmwareProfitU, 2),
                    'firmwareProfitR' => round($bestFirmwareProfitR, 2),
                    'firmwareIncreaseU' => round($bestFirmwareIncreaseU, 2),
                    'firmwareIncreaseR' => round($bestFirmwareIncreaseR, 2),
                    'firmwareIncreasePercent' => round($bestFirmwareIncreasePercent, 2),
                ]) }}
            </p><br>
        @endif

        <p>
            {{ __('descriptions.calculator.params', [
                'model' => $selModel['n'],
                'version' => $selVersion['h'] . $selVersion['m'],
                'efficiency' => $selVersion['e'] . ' J/' . $selVersion['m'],
                'power' => $selVersion['e'] * $selVersion['h'],
                'tariff' => $BASE_TARIFF,
                'coins' => $coins,
                'comission' => $haveProfits ? $fee : 0,
                'uptime' => $BASE_UPTIME,
                'algorithm' => $algorithm,
            ]) }}
        </p><br>

        <p>
            {{ __('descriptions.calculator.summary', ['model' => $selModel['n'], 'algorithm' => $algorithm, 'profit' => round($profitAfterTaxU, 2)]) }}
        </p>
    </div>

    <button @click="show = !show" class="mt-2 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600">
        <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
    </button>
</div>
