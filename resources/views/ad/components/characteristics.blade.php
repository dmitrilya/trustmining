<div class="mt-4">
    <x-characteristics.characteristics>
        @if ($ad->adcategory->name == 'miners')
            <x-characteristics.characteristic name="Manufacturer" :value="$ad->asicVersion->asicModel->asicBrand->name" />
            <x-characteristics.characteristic name="Algorithm" :value="$ad->asicVersion->asicModel->algorithm->name" />
            <x-characteristics.characteristic name="Efficiency" :value="$ad->asicVersion->efficiency . 'j/' . $ad->asicVersion->measurement" />
            <x-characteristics.characteristic name="Power" :value="$ad->asicVersion->efficiency * $ad->asicVersion->hashrate . __('kW/h')" />
            @if ($ad->asicVersion->asicModel->psus->count())
                <x-characteristics.characteristic name="Power connector" :value="$ad->asicVersion->asicModel->psus->first()->connector" />
            @endif
            <x-characteristics.characteristic name="Release date" :value="$ad->asicVersion->asicModel->release->translatedFormat('j M Y')" />
        @elseif ($ad->adcategory->name == 'gpus')
            <x-characteristics.characteristic name="Power" :value="$ad->gpuModel->max_power" itemprop="additionalProperty" :unit="['prop' => 'unitText', 'content' => 'kW/h']" />
            <x-characteristics.characteristic name="Engine manufacturer" :value="$ad->gpuModel->gpuEngineModel->gpuEngineBrand->name . ' (' . __($ad->gpuModel->gpuEngineModel->gpuEngineBrand->country) . ')'" />
            <x-characteristics.characteristic name="Engine model" :value="$ad->gpuModel->gpuEngineModel->name" />
            <x-characteristics.characteristic name="Fuel consumption (m³/h)" :value="$ad->gpuModel->fuel_consumption" />
            <x-characteristics.characteristic name="Country" :value="__($ad->gpuModel->gpuBrand->country)" />
        @endif
    </x-characteristics.characteristics>

    @if ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpus')
        <a class="block mt-4 ml-auto w-fit text-xs xs:text-sm text-indigo-500 hover:text-indigo-600"
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

    @if ($ad->adCategory->name == 'firmwares')
        <div class="overflow-hidden border border-slate-300 dark:border-slate-700 rounded-xl">
            <table class="min-w-full divide-y divide-slate-300 dark:divide-slate-700 text-left text-xs xs:text-sm text-slate-800 dark:text-slate-200">
                <thead class="bg-white/40 dark:bg-slate-900/40 text-slate-600 dark:text-slate-400">
                    <tr>
                        <th class="px-2 xs:px-4 py-2">{{ $ad->asicVersion->measurement }}/s</th>
                        <th class="px-2 xs:px-4 py-2">{{ __('Eff.') }} j/{{ $ad->asicVersion->measurement }}</th>
                        <th class="px-2 xs:px-4 py-2">{{ __('Strain') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                    @foreach (collect($ad->props['Modes'])->sortBy('h') as $mode)
                        @php
                            $strain = App\Enums\FirmwareModeStrainLevel::from($mode['s']);
                        @endphp

                        <tr class="{{ $strain->bg() }} {{ $strain->text() }}">
                            <td class="px-2 xs:px-4 py-2">{{ $mode['h'] }}</td>
                            <td class="px-2 xs:px-4 py-2">{{ $mode['e'] }}</td>
                            <td class="px-2 xs:px-4 py-2">{{ __('characteristics.strain_level.' . $strain->name()) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
