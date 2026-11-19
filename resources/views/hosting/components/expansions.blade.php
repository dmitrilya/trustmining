<div x-data="{
    expansions: {{ collect($expansions ?? []) }},
    capacity: '',
    date: '',
    addExpansion() {
        if (!this.capacity || !this.date) return;

        this.expansions.push({
            p: this.capacity,
            d: this.date,
        });

        this.capacity = '';
        this.date = '';

        this.$dispatch('datetime-clear');
    },
    removeExpansion(i) {
        this.expansions.splice(i, 1);
    },
    formatDate(dateStr) {
        if (!dateStr) return '';
        const [year, month] = dateStr.split('-');
        return `${month}.${year}`;
    }
}" @datetime-change="date = $event.detail.value" class="space-y-4">

    <template x-for="(expansion, i) in expansions" :key="i">
        <div>
            <input type="hidden" :name="`expansions[${i}][capacity]`" :value="expansion.p">
            <input type="hidden" :name="`expansions[${i}][planned_at]`" :value="expansion.d">
        </div>
    </template>

    <div>
        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200">
            {{ __('Expansion prospects') }}
        </h3>
        <p class="text-xxs xs:text-xs text-slate-600 dark:text-slate-400">
            {{ __('List the expansion expansions, indicating the allocated capacity and the expected completion date.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-1 xs:gap-2 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700">
        <x-inputs.text-input id="expansion_capacity" type="text" ::value="capacity" placeholder="{{ __('Power') }}, {{ __('kW') }}"
            class="w-full mt-0!" @input="capacity = filterDouble($el, 0, 1000000, 0); $el.value = capacity" />

        <x-inputs.date-picker name="planned_at" placeholder="Date" type="month" min="today" />

        <x-buttons.secondary-button class="sm:text-xs font-semibold" type="button" @click="addExpansion()">{{ __('Add') }}</x-buttons.secondary-button>
    </div>

    <template x-if="expansions.length">
        <div class="overflow-hidden border border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-950">
            <table class="min-w-full divide-y divide-slate-300 dark:divide-slate-700 text-left text-xs xs:text-sm text-slate-800 dark:text-slate-200">
                <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400">
                    <tr>
                        <th class="px-2 xs:px-4 py-2">{{ __('Power') }}</th>
                        <th class="px-2 xs:px-4 py-2">{{ __('Date') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                    <template x-for="(expansion, i) in expansions" :key="i">
                        <tr>
                            <td class="px-2 xs:px-4 py-2" x-text="expansion.p + ' {{ __('kW') }}'"></td>
                            <td class="px-2 xs:px-4 py-2" x-text="formatDate(expansion.d)"></td>
                            <td class="px-2 xs:px-4 py-2 text-right">
                                <button type="button" @click="removeExpansion(i)" class="text-red-600 dark:text-red-400 text-xs transition">
                                    {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </template>

    <x-inputs.input-error :messages="$errors->get('expansions')" />
</div>
