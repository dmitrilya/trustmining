<x-breadcrumbs>
    @if ($ad->adCategory->name == 'miners')
        <x-breadcrumb position="1" :href="route('database.asic-miners')" :name="__('ASIC-miners')" />
        <x-breadcrumb position="2" :href="route('database.asic-miners.brand', ['asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug])" :name="$ad->asicVersion->asicModel->asicBrand->name" />
        <x-breadcrumb position="3" :href="route('database.asic-miners.model', [
            'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
            'asicModel' => $ad->asicVersion->asicModel->slug,
        ])" :name="$ad->asicVersion->asicModel->name" />
        <x-breadcrumb position="4" :href="route('database.asic-miners.version', [
            'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
            'asicModel' => $ad->asicVersion->asicModel->slug,
            'asicVersion' => $ad->asicVersion->hashrate . $ad->asicVersion->measurement,
        ])" :name="$ad->asicVersion->hashrate . $ad->asicVersion->measurement" />
        <x-breadcrumb position="5" :name="$ad->user->name" />
    @elseif ($ad->adCategory->name == 'gpus')
        <x-breadcrumb position="1" :href="route('database.gas-gensets')" :name="__('Gas gensets')" />
        <x-breadcrumb position="2" :href="route('database.gas-gensets.brand', ['gpuBrand' => $ad->gpuModel->gpuBrand->slug])" :name="$ad->gpuModel->gpuBrand->name" />
        <x-breadcrumb position="3" :href="route('database.gas-gensets.model', [
            'gpuBrand' => $ad->gpuModel->gpuBrand->slug,
            'gpuModel' => $ad->gpuModel->slug,
        ])" :name="$ad->gpuModel->name" />
        <x-breadcrumb position="4" :name="$ad->user->name" />
    @else
        <x-breadcrumb position="1" :name="__($ad->adCategory->header)" />
    @endif
</x-breadcrumbs>
