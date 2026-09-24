<x-faqs.faqs>
    <x-faqs.faq i="1" :question="__('faq.asic.question_1', [
        'b' => $brand->name,
        'm' => $model->name,
    ])" :answer="__('faq.asic.answer_1', [
        'b' => $brand->name,
        'm' => $model->name,
        'cooling' => __('faq.asic.answer_1_cooling.' . $model->cooling_type->name),
    ])" />
    @if ($selectedVersion['p'])
        <x-faqs.faq i="2" :question="__('faq.asic.question_2', [
            'coin' => $model->algorithm->coins->first()->name,
            'b' => $brand->name,
            'm' => $model->name,
        ])" :answer="__('faq.asic.answer_2', [
            'b' => $brand->name,
            'm' => $model->name,
            'h' => $selectedVersion['h'] . $selectedVersion['m'] . '/s',
            'price' => $selectedVersion['p'],
            'company' => $selectedVersion['s'],
        ])" />
    @endif
    @php
        $unitString = $selectedVersion['m'];
        $availableTypes = ['h', 'sol', 'g', 'c', 'k'];

        $isPureType = in_array(strtolower($unitString), $availableTypes);

        $currentPrefix = $isPureType ? '' : substr($unitString, 0, 1);
        $type = $isPureType ? strtolower($unitString) : strtolower(substr($unitString, 1));

        $measurements = ['', 'k', 'M', 'G', 'T', 'P', 'E', 'Z'];

        $currentIndex = array_search($currentPrefix, $measurements);
        if ($currentIndex === false) {
            $currentIndex = 0;
        }

        $baseValue = $selectedVersion['h'] * pow(1000, $currentIndex);

        $results = [];
        $maxIndex = $currentIndex + 1;

        if ($maxIndex >= count($measurements)) {
            $maxIndex = count($measurements) - 1;
        }

        for ($i = 0; $i <= $maxIndex; $i++) {
            if ($i === $currentIndex) {
                continue;
            }

            $targetPrefix = $measurements[$i];

            $convertedVal = $baseValue / pow(1000, $i);

            if (floor($convertedVal) == $convertedVal) {
                $formattedVal = number_format($convertedVal, 0, ',', ' ');
            } else {
                $precision = $convertedVal < 0.01 ? 4 : 2;
                $formattedVal = number_format($convertedVal, $precision, ',', ' ');
            }

            $prefixName = __("faq.asic.units.prefixes.{$targetPrefix}");
            $unitName = __("faq.asic.units.names.{$type}");

            $results[] = "<b>{$formattedVal}</b> " . trim("{$prefixName}{$unitName}");
        }

        $convertedText = implode(', ', $results);
    @endphp

    <x-faqs.faq i="3" :question="__('faq.asic.question_3', [
        'h' => $selectedVersion['h'],
        'mes' => $selectedVersion['m'] . '/s',
        'b' => $brand->name,
        'm' => $model->name,
    ])" :answer="__('faq.asic.answer_3', [
        'h' => '<b>' . $selectedVersion['h'] . '</b>  ' . __('faq.asic.units.prefixes.' . $currentPrefix) . __('faq.asic.units.names.' . $type),
        'converted_text' => $convertedText,
    ])" />

    @if ($algorithms[$selectedVersion['a']]['n'] == 'SHA-256')
        @php
            $p =
                collect($algorithms[$selectedVersion['a']]['p'])
                    ->pluck('c')
                    ->flatten(1)
                    ->where('n', 'Bitcoin')
                    ->first()['p'] * $selectedVersion['h'];
            $coin = \App\Models\Database\Coin::where('name', 'Bitcoin')->first();
            $r = $coin->reward_block;
            $d = $coin->networkDifficulties()->latest()->first('difficulty')->difficulty;
            $btcTime = round(1 / $p);
        @endphp

        <x-faqs.faq i="4" :question="__('faq.asic.question_4', ['b' => $brand->name, 'm' => $model->name, 'h' => $selectedVersion['h'] . $selectedVersion['m'] . '/s'])" :answer="__('faq.asic.answer_4', [
            'd' => number_format($d),
            'r' => $r,
            'b' => $brand->name,
            'm' => $model->name,
            'h' => $selectedVersion['h'] . ' ' . $selectedVersion['m'] . '/s',
            'btc_time' => $btcTime . ' ' . trans_choice('time.days', $btcTime),
            'p' => number_format($p, 8),
            'ps' => $p * 100000000,
        ])" />
    @endif

    <x-faqs.faq i="5" :question="__('faq.asic.question_5', ['b' => $brand->name, 'm' => $model->name])" :answer="__('faq.asic.answer_5', ['m' => $model->name])" />
    <x-faqs.faq i="6" :question="__('faq.asic.question_6', ['b' => $brand->name, 'm' => $model->name])" :answer="__('faq.asic.answer_6', ['m' => $model->name])" />
</x-faqs.faqs>
