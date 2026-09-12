<div>
    @php
        if (!$description && in_array($ad->adCategory->name, ['miners', 'gpus'])) {
            $availability =
                $ad->props['Availability'] === 'Preorder'
                    ? __('descriptions.ad.availability.preorder', ['days' => $ad->props['Waiting (days)']])
                    : __('descriptions.ad.availability.stock');

            if ($ad->adCategory->name === 'miners') {
                $condition = $ad->props['Condition'] === 'New' ? __('descriptions.ad.conditions.new_miner') : __('descriptions.ad.conditions.used_miner');

                $description = __('descriptions.ad.miner_desc', [
                    'user' => $ad->user->name,
                    'condition' => $condition,
                    'brand' => $ad->asicVersion->asicModel->asicBrand->name,
                    'model' => $ad->asicVersion->asicModel->name,
                    'hashrate' => $ad->asicVersion->hashrate,
                    'measurement' => $ad->asicVersion->measurement,
                    'city' => $ad->office->city,
                    'availability' => $availability,
                ]);
            } elseif ($ad->adCategory->name === 'gpus') {
                $condition = $ad->props['Condition'] === 'New' ? __('descriptions.ad.conditions.new_gpu') : __('descriptions.ad.conditions.used_gpu');

                $description = __('descriptions.ad.gpu_desc', [
                    'user' => $ad->user->name,
                    'condition' => $condition,
                    'brand' => $ad->gpuModel->gpuBrand->name,
                    'model' => $ad->gpuModel->name,
                    'power' => $ad->gpuModel->max_power,
                    'city' => $ad->office->city,
                    'availability' => $availability,
                ]);
            }
        }
    @endphp

    <h2 class="font-extrabold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Ad description') }}</h2>

    <div itemprop="description"
        class="ql-editor mt-5 text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400{{ isset($moderation->data['description']) ? ' border border-indigo-500' : '' }}">
        {!! $description !!}
    </div>
</div>
