<x-filter-filter type="checkbox" :name="__('Material')" :items="[
    ['url_name' => 'LP', 'name' => __('LP')],
    ['url_name' => 'OSB', 'name' => __('OSB')],
    ['url_name' => 'Metal', 'name' => __('Metal')],
    ['url_name' => 'Another', 'name' => __('Another')],
]" field="Material"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Capacity')" :items="[
    ['url_name' => '1', 'name' => '1'],
    ['url_name' => '2', 'name' => '2'],
    ['url_name' => '3', 'name' => '3'],
    ['url_name' => '>3', 'name' => __('more') . ' 3'],
]" field="Capacity"></x-filter-filter>
