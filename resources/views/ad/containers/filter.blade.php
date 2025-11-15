<x-filter-filter type="checkbox" :name="__('Capacity')" :items="[
    ['url_name' => '<50', 'name' => '50'],
    ['url_name' => '><50-100', 'name' => '100'],
    ['url_name' => '><100-200', 'name' => '200'],
    ['url_name' => '><200-300', 'name' => '300'],
    ['url_name' => '>300', 'name' => __('more') . ' 300'],
]" field="Capacity"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Power (kW)')" :items="[
    ['url_name' => '<200', 'name' => '200' . __('kW')],
    ['url_name' => '><200-500', 'name' => '500' . __('kW')],
    ['url_name' => '><500-1000', 'name' => '1000' . __('kW')],
    ['url_name' => '><1000-1500', 'name' => '1500' . __('kW')],
    ['url_name' => '>1500', 'name' => __('more') . ' 1500' . __('kW')],
]" field="Power_(kW)"></x-filter-filter>