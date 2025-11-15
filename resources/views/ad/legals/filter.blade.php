<x-select :label="__('Service')" name="Service" :items="App\Models\AdCategory::where('name', 'legals')
    ->with('ads:ad_category_id,props')
    ->first()
    ->ads->pluck('props')
    ->pluck('Service')
    ->unique()
    ->map(fn($area) => ['key' => $area, 'value' => __($area)])
    ->prepend(['key' => null, 'value' => __('All')])
    ->keyBy('key')" />
