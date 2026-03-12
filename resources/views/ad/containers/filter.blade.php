<x-filter-filter type="checkbox" :name="__('Capacity')" :items="[
    ['slug' => '<50', 'name' => '50'],
    ['slug' => '><50-100', 'name' => '100'],
    ['slug' => '><100-200', 'name' => '200'],
    ['slug' => '><200-300', 'name' => '300'],
    ['slug' => '>300', 'name' => __('more') . ' 300'],
]" field="Capacity"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Power (kW)')" :items="[
    ['slug' => '<200', 'name' => '200' . __('kW')],
    ['slug' => '><200-500', 'name' => '500' . __('kW')],
    ['slug' => '><500-1000', 'name' => '1000' . __('kW')],
    ['slug' => '><1000-1500', 'name' => '1500' . __('kW')],
    ['slug' => '>1500', 'name' => __('more') . ' 1500' . __('kW')],
]" field="Power_(kW)"></x-filter-filter>