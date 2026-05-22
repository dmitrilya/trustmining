<?php

return [

    'ads' => [
        'max_count_without_tariff' => env('MAX_ADS_WITHOUT_TARIFF', 2),
    ],

    'roulette' => [
        'period' => env('ROULETTE_PERIOD', 7),
        'extra_spin_name' => env('ROULETTE_EXTRA_SPIN_NAME', 'Extra Spin')
    ]

];
