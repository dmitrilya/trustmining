<x-filter-filter type="checkbox" :name="__('Capacity')" :items="[
    ['slug' => '<3', 'name' => '3'],
    ['slug' => '><3-6', 'name' => '6'],
    ['slug' => '><6-9', 'name' => '9'],
    ['slug' => '>9', 'name' => __('more') . ' 9'],
]" field="Capacity"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Heating area (m²)')" :items="[
    ['slug' => '<30', 'name' => '30' . __('m²')],
    ['slug' => '><30-60', 'name' => '60' . __('m²')],
    ['slug' => '><60-100', 'name' => '100' . __('m²')],
    ['slug' => '><100-150', 'name' => '150' . __('m²')],
    ['slug' => '>150', 'name' => __('more') . ' 150' . __('m²')],
]" field="Heating_area_(m²)"></x-filter-filter>