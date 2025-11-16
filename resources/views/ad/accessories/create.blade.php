<div class="space-y-6" x-data="{ props: { Category: 'Cables, adapters and connectors', 'Connector 1': 'C13', 'Connector 2': 'Without plug', 'Length (m)': 1.5 } }">
    <input type="hidden" name="props" :value="JSON.stringify(props)">

    <x-select :label="__('Category')" name="Category"
        handleChange="(category => {
            switch (category) {
                case('Cables, adapters and connectors'):
                    props = { Category: 'Cables, adapters and connectors', 'Connector 1': 'C13', 'Connector 2': 'Without plug', 'Length (m)': 1.5 };
                case('Coolers'):
                    props = { Category: 'Coolers', 'Size (mm)': 140, 'Thickness (mm)': 38, 'Speed (rpm)': 7000, 'Amperage (A)': 9, 'Connector (pin)': 4, 'Model': 'PFC1412HE-00' };
            }
        })"
        :items="collect([
            ['key' => 'Cables, adapters and connectors', 'value' => __('Cables, adapters and connectors')],
            ['key' => 'Coolers', 'value' => __('Coolers')],
        ])->keyBy('key')" />

    <template x-if="props['Category'] == 'Cables, adapters and connectors'">
        <div class="space-y-6">
            <x-select :label="__('Connector 1')" name="Connector 1" handleChange="(connector => props['Connector 1'] = connector)"
                :items="collect([
                    ['key' => 'C13', 'value' => 'C13'],
                    ['key' => '2C13', 'value' => '2C13'],
                    ['key' => 'C14', 'value' => 'C14'],
                    ['key' => '2C14', 'value' => '2C14'],
                    ['key' => 'C19', 'value' => 'C19'],
                    ['key' => '2C19', 'value' => '2C19'],
                    ['key' => 'C20', 'value' => 'C20'],
                    ['key' => '2C20', 'value' => '2C20'],
                    ['key' => 'P13', 'value' => 'P13'],
                    ['key' => '2P13', 'value' => '2P13'],
                    ['key' => 'P14', 'value' => 'P14'],
                    ['key' => '2P14', 'value' => '2P14'],
                    ['key' => 'P33', 'value' => 'P33'],
                    ['key' => '2P33', 'value' => '2P33'],
                    ['key' => 'P34', 'value' => 'P34'],
                    ['key' => '2P34', 'value' => '2P34'],
                    ['key' => 'M25', 'value' => 'M25'],
                    ['key' => 'SA2-30', 'value' => 'SA2-30'],
                    ['key' => 'LP-20-J04PE-01', 'value' => 'LP-20-J04PE-01'],
                ])->keyBy('key')" />

            <x-select :label="__('Connector 2')" name="Connector 2"
                handleChange="(connector => props['Connector 2'] = connector)" :items="collect([
                    ['key' => 'Without plug', 'value' => __('Without plug')],
                    ['key' => 'European plug (S22)', 'value' => __('European plug (S22)')],
                    ['key' => 'Chinese plug', 'value' => __('Chinese plug')],
                    ['key' => '2C13', 'value' => '2C13'],
                    ['key' => 'C14', 'value' => 'C14'],
                    ['key' => '2C14', 'value' => '2C14'],
                    ['key' => 'C19', 'value' => 'C19'],
                    ['key' => '2C19', 'value' => '2C19'],
                    ['key' => 'C20', 'value' => 'C20'],
                    ['key' => '2C20', 'value' => '2C20'],
                    ['key' => 'P13', 'value' => 'P13'],
                    ['key' => '2P13', 'value' => '2P13'],
                    ['key' => 'P14', 'value' => 'P14'],
                    ['key' => '2P14', 'value' => '2P14'],
                    ['key' => 'P33', 'value' => 'P33'],
                    ['key' => '2P33', 'value' => '2P33'],
                    ['key' => 'P34', 'value' => 'P34'],
                    ['key' => '2P34', 'value' => '2P34'],
                    ['key' => 'M25', 'value' => 'M25'],
                    ['key' => 'SA2-30', 'value' => 'SA2-30'],
                    ['key' => 'LP-20-J04PE-01', 'value' => 'LP-20-J04PE-01'],
                ])->keyBy('key')" />

            <div>
                <x-input-label for="length" :value="__('Length (m)')" />
                <x-text-input id="length" name="length" type="number" autocomplete="length" value="1.5"
                    @change="props['Length (m)'] = $el.value;" />
                <x-input-error :messages="$errors->get('length')" />
            </div>
        </div>
    </template>

    <template x-if="props['Category'] == 'Coolers'">
        <div class="space-y-6">
            <div>
                <x-input-label for="size" :value="__('Size (mm)')" />
                <x-text-input id="size" name="size" type="number" autocomplete="size" value="140"
                    @change="props['Size (mm)'] = $el.value;" />
                <x-input-error :messages="$errors->get('size')" />
            </div>

            <div>
                <x-input-label for="thickness" :value="__('Thickness (mm)')" />
                <x-text-input id="thickness" name="thickness" type="number" autocomplete="thickness" value="38"
                    @change="props['Thickness (mm)'] = $el.value;" />
                <x-input-error :messages="$errors->get('thickness')" />
            </div>

            <div>
                <x-input-label for="speed" :value="__('Speed (rpm)')" />
                <x-text-input id="speed" name="speed" type="number" autocomplete="speed" value="7000"
                    @change="props['Speed (rpm)'] = $el.value;" />
                <x-input-error :messages="$errors->get('speed')" />
            </div>

            <div>
                <x-input-label for="amperage" :value="__('Amperage (A)')" />
                <x-text-input id="amperage" name="amperage" type="number" autocomplete="amperage" value="9"
                    @change="props['Amperage (A)'] = $el.value;" />
                <x-input-error :messages="$errors->get('amperage')" />
            </div>

            <div>
                <x-input-label for="connector" :value="__('Connector (pin)')" />
                <x-text-input id="connector" name="connector" type="number" autocomplete="connector" value="4"
                    @change="props['Connector (pin)'] = $el.value;" />
                <x-input-error :messages="$errors->get('connector')" />
            </div>

            <div>
                <x-input-label for="model" :value="__('Model')" />
                <x-text-input id="model" name="model" type="number" autocomplete="model"
                    placeholder="PFC1412HE-00" @change="props['Model'] = $el.value;" />
                <x-input-error :messages="$errors->get('model')" />
            </div>
        </div>
    </template>
</div>
