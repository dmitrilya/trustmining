<x-characteristics>
    @if ($ad->adcategory->name == 'miners')
        <x-characteristic name="Manufacturer" :value="$ad->asicVersion->asicModel->asicBrand->name" />
        <x-characteristic name="Algorithm" :value="$ad->asicVersion->asicModel->algorithm->name" />
        <x-characteristic name="Efficiency" :value="$ad->asicVersion->efficiency . 'j/' . $ad->asicVersion->measurement" />
        <x-characteristic name="Power" :value="$ad->asicVersion->efficiency * $ad->asicVersion->hashrate . __('kW/h')" />
        <x-characteristic name="Release date" :value="$ad->asicVersion->asicModel->release->translatedFormat('j M Y')" />
    @elseif ($ad->adcategory->name == 'gpus')
        <x-characteristic name="Power" :value="$ad->gpuModel->max_power" itemprop="additionalProperty" :unit="['prop' => 'unitText', 'content' => 'kW/h']" />
        <x-characteristic name="Engine manufacturer" :value="$ad->gpuModel->gpuEngineModel->gpuEngineBrand->name .
            ' (' .
            __($ad->gpuModel->gpuEngineModel->gpuEngineBrand->country) .
            ')'" />
        <x-characteristic name="Engine model" :value="$ad->gpuModel->gpuEngineModel->name" />
        <x-characteristic name="Fuel consumption (m³/h)" :value="$ad->gpuModel->fuel_consumption" />
        <x-characteristic name="Country" :value="__($ad->gpuModel->gpuBrand->country)" />
    @endif
</x-characteristics>

@if ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpus')
    <a class="block mt-6 ml-auto w-fit text-xs xs:text-sm text-indigo-500 hover:text-indigo-600"
        href="{{ $ad->adCategory->name == 'miners'
            ? route('database.asic-miners.model', [
                'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
                'asicModel' => $ad->asicVersion->asicModel->slug,
            ])
            : route('database.gas-gensets.model', [
                'gpuBrand' => $ad->gpuModel->gpuBrand->slug,
                'gpuModel' => $ad->gpuModel->slug,
            ]) }}">
        {{ __('All characteristics') }}
    </a>
@endif
