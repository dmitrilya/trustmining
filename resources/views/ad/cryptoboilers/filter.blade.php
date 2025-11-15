<x-filter-filter type="checkbox" :name="__('Capacity')" :items="[
    ['url_name' => '<3', 'name' => '3'],
    ['url_name' => '><3-6', 'name' => '6'],
    ['url_name' => '><6-9', 'name' => '9'],
    ['url_name' => '>9', 'name' => __('more') . ' 9'],
]" field="Capacity"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Heating area (m²)')" :items="[
    ['url_name' => '<30', 'name' => '30' . __('m²')],
    ['url_name' => '><30-60', 'name' => '60' . __('m²')],
    ['url_name' => '><60-100', 'name' => '100' . __('m²')],
    ['url_name' => '><100-150', 'name' => '150' . __('m²')],
    ['url_name' => '>150', 'name' => __('more') . ' 150' . __('m²')],
]" field="Heating_area_(m²)"></x-filter-filter>