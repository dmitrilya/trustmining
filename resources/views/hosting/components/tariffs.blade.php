<div x-data="{
    tariffs: {{ collect($tariffs) }},
    tariff: '',
    uptime: '',
    addTariff() {
        if (!this.tariff || !this.uptime) return;
        this.tariffs.push({
            t: this.tariff,
            u: this.uptime,
        });
        this.tariff = '';
        this.uptime = '';
    },
    removeTariff(i) {
        this.tariffs.splice(i, 1);
    }
}" class="space-y-4">
    <template x-for="(tariff, i) in tariffs" :key="i">
        <div>
            <input type="hidden" :name="`tariffs[${i}][t]`" :value="tariff.t">
            <input type="hidden" :name="`tariffs[${i}][u]`" :value="tariff.u">
        </div>
    </template>

    <div>
        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">
            {{ __('Hosting rates') }}
        </h3>
        <p class="text-xxs xs:text-xs text-slate-600 dark:text-slate-400">
            {{ __('List all available tariffs, indicating the price and uptime for each.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 xs:grid-cols-3 gap-1 xs:gap-2 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700">
        <x-inputs.text-input id="tariff_tariff" type="text" ::value="tariff" placeholder="₽/{{ __('kW') }}" class="w-full !mt-0"
            @input="tariff = filterDouble($el, 0, 10, 2);$el.value = tariff" />
        <x-inputs.text-input id="tariff_uptime" type="text" ::value="uptime" placeholder="%" class="w-full !mt-0"
            @input="uptime = filterDouble($el, 0, 100, 2);$el.value = uptime" />
        <x-buttons.secondary-button class="sm:text-xs font-semibold" type="button" @click="addTariff()">＋ {{ __('Add') }}</x-buttons.secondary-button>
    </div>

    <template x-if="tariffs.length">
        <div class="overflow-hidden border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950">
            <table class="min-w-full divide-y divide-slate-300 dark:divide-slate-700 text-left text-xs xs:text-sm text-slate-800 dark:text-slate-200">
                <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400">
                    <tr>
                        <th class="px-2 xs:px-4 py-2">{{ __('Price') }}</th>
                        <th class="px-2 xs:px-4 py-2">{{ __('Uptime') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                    <template x-for="(tariff, i) in tariffs" :key="i">
                        <tr>
                            <td class="px-2 xs:px-4 py-2" x-text="tariff.t + ' ₽/{{ __('kW') }}'"></td>
                            <td class="px-2 xs:px-4 py-2" x-text="tariff.u + '%'"></td>
                            <td class="px-2 xs:px-4 py-2 text-right">
                                <button type="button" @click="removeTariff(i)" class="text-red-700 hover:text-red-500 text-xs transition">
                                    {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </template>

    <x-inputs.input-error :messages="$errors->get('tariffs')" />
</div>
