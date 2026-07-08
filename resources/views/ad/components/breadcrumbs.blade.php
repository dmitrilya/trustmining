<x-breadcrumbs.breadcrumbs>
    @if ($ad->adCategory->name == 'miners')
        <x-breadcrumbs.breadcrumb position="1" :href="route('database.asic-miners')" :name="__('ASIC-miners')" />
        <x-breadcrumbs.breadcrumb position="2" :href="route('database.asic-miners.brand', ['asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug])" :name="$ad->asicVersion->asicModel->asicBrand->name" />
        <x-breadcrumbs.breadcrumb position="3" :href="route('database.asic-miners.model', [
            'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
            'asicModel' => $ad->asicVersion->asicModel->slug,
        ])" :name="$ad->asicVersion->asicModel->name" />
        <x-breadcrumbs.breadcrumb position="4" :href="route('database.asic-miners.version', [
            'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
            'asicModel' => $ad->asicVersion->asicModel->slug,
            'asicVersion' => $ad->asicVersion->hashrate . $ad->asicVersion->measurement,
        ])" :name="$ad->asicVersion->hashrate . $ad->asicVersion->measurement" />
        <x-breadcrumbs.breadcrumb position="5" :name="$ad->user->name" />
    @elseif ($ad->adCategory->name == 'gpus')
        <x-breadcrumbs.breadcrumb position="1" :href="route('database.gas-gensets')" :name="__('Gas generators')" />
        <x-breadcrumbs.breadcrumb position="2" :href="route('database.gas-gensets.brand', ['gpuBrand' => $ad->gpuModel->gpuBrand->slug])" :name="$ad->gpuModel->gpuBrand->name" />
        <x-breadcrumbs.breadcrumb position="3" :href="route('database.gas-gensets.model', [
            'gpuBrand' => $ad->gpuModel->gpuBrand->slug,
            'gpuModel' => $ad->gpuModel->slug,
        ])" :name="$ad->gpuModel->name" />
        <x-breadcrumbs.breadcrumb position="4" :name="$ad->user->name" />
    @elseif ($ad->adCategory->name == 'legals')
        <x-breadcrumbs.breadcrumb position="1" :href="route('ads', ['adCategory' => 'legals'])" :name="__('Cryptocurrency lawyers')" />
        <x-breadcrumbs.breadcrumb position="2" :name="__($ad->user->name)" />
    @elseif ($ad->adCategory->name == 'accessories')
        <x-breadcrumbs.breadcrumb position="1" :href="route('ads', ['adCategory' => 'accessories'])" :name="__('Consumables and accessories')" />
        <x-breadcrumbs.breadcrumb position="2" :href="route('ads', ['adCategory' => 'accessories', 'Category[]' => $ad->props['Category']])" :name="__($ad->props['Category'])" />
        <x-breadcrumbs.breadcrumb position="3" :name="__($ad->user->name)" />
    @else
        <x-breadcrumbs.breadcrumb position="1" :href="route('ads', ['adCategory' => $ad->adCategory->name])" :name="__($ad->adCategory->header)" />
        <x-breadcrumbs.breadcrumb position="2" :name="__($ad->user->name)" />
    @endif
</x-breadcrumbs.breadcrumbs>
