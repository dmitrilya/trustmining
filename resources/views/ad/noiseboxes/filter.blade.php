<x-filter-filter type="checkbox" :name="__('Material')" :items="[
    ['slug' => 'LP', 'name' => __('LP')],
    ['slug' => 'OSB', 'name' => __('OSB')],
    ['slug' => 'Metal', 'name' => __('Metal')],
    ['slug' => 'Another', 'name' => __('Another')],
]" field="Material"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Capacity')" :items="[
    ['slug' => '1', 'name' => '1'],
    ['slug' => '2', 'name' => '2'],
    ['slug' => '3', 'name' => '3'],
    ['slug' => '>3', 'name' => __('more') . ' 3'],
]" field="Capacity"></x-filter-filter>
