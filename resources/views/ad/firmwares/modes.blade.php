@php
    $strainLevels = collect(App\Enums\FirmwareModeStrainLevel::cases())
        ->map(fn($mode) => ['key' => $mode->value, 'value' => __('characteristics.strain_level.' . $mode->name())])
        ->keyBy('key');
@endphp

<div x-data="{
    modes: {{ $modes }},
    hashrate: '',
    efficiency: '',
    strain: '{{ $strainLevels->first()['key'] }}',
    strainLevels: {{ $strainLevels }},
    addMode() {
        if (!this.hashrate || !this.efficiency || !this.strain) return;
        this.modes.push({
            h: this.hashrate,
            e: this.efficiency,
            s: this.strain
        });
        this.hashrate = '';
        this.efficiency = '';
        this.strain = '';
        let props = JSON.parse($refs.props_firmwares.value);
        props['Modes'] = this.modes;
        $refs.props_firmwares.value = JSON.stringify(props);
    },
    removeMode(index) {
        this.modes.splice(index, 1);
        let props = JSON.parse($refs.props_firmwares.value);
        props['Modes'] = this.modes;
        $refs.props_firmwares.value = JSON.stringify(props);
    }
}" class="space-y-4">
    <div>
        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">
            {{ __('Firmware operating modes') }}
        </h3>
        <p class="text-xxs xs:text-xs text-slate-600 dark:text-slate-400">
            {{ __('Add modes so users can calculate profitability.') }}
        </p>
    </div>

    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-1 xs:gap-2 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700">
        <x-inputs.text-input id="mode_hashrate" type="text" x-model="hashrate" ::placeholder="measurement + '/s'" class="w-full !mt-0" />
        <x-inputs.text-input id="mode_efficiency" type="number" step="0.1" x-model="efficiency" ::placeholder="'{{ __('Eff.') }}' + ' j/' + measurement" class="w-full !mt-0" />
        <x-inputs.select handleChange="(strainLevel => strain = strainLevel)" :items="collect($strainLevels)" size="lg" />
        <x-buttons.secondary-button class="sm:text-xs font-semibold" type="button" @click="addMode()">＋ {{ __('Add') }}</x-buttons.secondary-button>
    </div>

    <template x-if="modes.length">
        <div class="overflow-hidden border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950">
            <table class="min-w-full divide-y divide-slate-300 dark:divide-slate-700 text-left text-xs xs:text-sm text-slate-800 dark:text-slate-200">
                <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400">
                    <tr>
                        <th class="px-2 xs:px-4 py-2" x-text="measurement + '/s'"></th>
                        <th class="px-2 xs:px-4 py-2" x-text="'{{ __('Eff.') }}' + ' j/' + measurement"></th>
                        <th class="px-2 xs:px-4 py-2">{{ __('Strain') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                    <template x-for="(mode, index) in modes" :key="index">
                        <tr>
                            <td class="px-2 xs:px-4 py-2" x-text="mode.h"></td>
                            <td class="px-2 xs:px-4 py-2" x-text="mode.e"></td>
                            <td class="px-2 xs:px-4 py-2" x-text="strainLevels[mode.s].value"></td>
                            <td class="px-2 xs:px-4 py-2 text-right">
                                <button type="button" @click="removeMode(index)"
                                    class="text-red-600 hover:text-red-500 text-xs px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors">
                                    {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </template>

    <x-inputs.input-error :messages="$errors->get('modes')" />
</div>
