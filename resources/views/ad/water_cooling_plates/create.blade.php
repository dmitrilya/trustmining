<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_water_cooling_plates" value='{"For which models": []}'>

    <x-inputs.multiselect name="models" label="For which models" :all="App\Models\Database\AsicModel::pluck('name')"
        handleChange="let props = JSON.parse($refs.props_water_cooling_plates.value); props['For which models'] = selected; $refs.props_water_cooling_plates.value = JSON.stringify(props);" />
</div>
