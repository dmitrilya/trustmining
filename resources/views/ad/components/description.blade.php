<div>
    @php
        if (!$description && ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpus')) {
            if ($ad->adCategory->name == 'miners') {
                $description = "<p>{$ad->user->name} предлагает <b>" . ($ad->props['Condition'] == 'New' ? 'новый' : 'б/у') . "</b> ASIC майнер <b>{$ad->asicVersion->asicModel->asicBrand->name} {$ad->asicVersion->asicModel->name}</b> 
с хешрейтом <b>{$ad->asicVersion->hashrate} {$ad->asicVersion->measurement}</b> в городе <b>{$ad->office->city}</b>.</p>

<p>Оборудование доступно к покупке <b>" . ($ad->props['Availability'] == 'Preorder' ? 'под заказ с ожиданием до ' . $ad->props['Waiting (days)'] . ' дней' : 'из наличия со склада') . "</b>.</p><p><br /></p>
Уточните наличие и условия доставки у продавца, связавшить в нашем онлайн-чате или по телефону.";
            } elseif ($ad->adCategory->name == 'gpus') {
                $description = "<p>{$ad->user->name} предлагает <b>" . ($ad->props['Condition'] == 'New' ? 'новую' : 'б/у') . "</b> газопоршневую электростанцию <b>{$ad->gpuModel->gpuBrand->name} {$ad->gpuModel->name}</b> 
с максимальной мощностью <b>{$ad->gpuModel->max_power} кВт/ч</b> в городе <b>{$ad->office->city}</b>.</p>

<p>ГПУ доступна к покупке <b>" . ($ad->props['Availability'] == 'Preorder' ? 'под заказ с ожиданием до ' . $ad->props['Waiting (days)'] . ' дней' : 'из наличия со склада') . "</b>.</p><p><br /></p>
Уточните наличие и условия доставки у продавца, связавшить в нашем онлайн-чате или по телефону.";
            }
        }
    @endphp
    <h2 class="font-bold tracking-tight text-slate-800 dark:text-slate-200">
        {{ __('Ad description') }}</h2>

    <div itemprop="description"
        class="ql-editor mt-5 text-xxs xs:text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400{{ isset($moderation->data['description']) ? ' border border-indigo-500' : '' }}">
        {!! $description !!}
    </div>
</div>
