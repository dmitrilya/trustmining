<?php

return [
    'base' => 50,
    'min' => 0,
    'max' => 100,

    'log_diff_threshold' => 10,

    'green' => 75,
    'yellow' => 55,

    'directions' => [
        'map' => [
            'miners' => 'miners',
            'accessories' => 'miners',
            'water_cooling_plates' => 'miners',
            'legals' => 'legals',
            'containers' => 'containers',
            'cryptoboilers' => 'cryptoboilers',
            'firmwares' => 'firmwares',
            'monitorings' => 'firmwares',
            'gpus' => 'gpus',
        ],
        'weights' => [
            'miners' => 11,
            'accessories' => 1,
            'water_cooling_plates' => 1,
            'legals' => 3,
            'containers'  => 8,
            'noiseboxes' => 2,
            'cryptoboilers' => 4,
            'firmwares' => 4,
            'monitorings' => 4,
            'gpus' => 9,
            'hosting' => 35,
            'service' =>  15,
            'exchanger' => 3,
        ],
    ],

    'factors' => [
        'active' => [
            'company_exists',
            'legal_entity',
            'company_status',
            'branches',
            'invalid_registry_data',
            'registration_age',
            'website',
            'video',
            'images',
            'capital',
            'income',
            'employees',
            'reviews',
            'fake_reviews',
            'offices',
            'unique_content',
            'response_time',
            'registry',
            'visiting_territory',
        ],

        'default' => [
            'company_exists' => [
                'source' => 'company.exists',
                'penalty' => -20,
            ],

            'legal_entity' => [
                'source' => 'company.legal_entity',
                'bonus' => 3,
            ],

            'company_status' => [
                'source' => 'company.status_active',
                'penalty' => -35,
            ],

            'branches' => [
                'source' => 'company.branches',
                'bonus' => 3,
            ],

            'invalid_registry_data' => [
                'source' => 'company.invalid',
                'penalty' => -15,
            ],

            'registration_age' => [
                'source' => 'company.registration_age',
                'thresholds' => [
                    36 => 10,
                    24 => 6,
                    18 => 3,
                    8  => 0,
                    0  => -3,
                ],
            ],

            'website' => [
                'source' => 'company.site',
                'bonus' => 1,
            ],

            'video' => [
                'source' => 'company.video',
                'bonus' => 2,
            ],

            'images' => [
                'source' => 'company.images',
                'thresholds' => [
                    5 => 2,
                    1 => 0,
                    0 => -4,
                ],
            ],

            'capital' => [
                'source' => 'company.capital',
                'condition' => [
                    'source' => 'company.exists',
                    'operator' => '==',
                    'value' => true,
                ],
                'thresholds' => [
                    20000 => 2,
                    0 => 0,
                ],
            ],

            'income' => [
                'source' => 'company.income',
                'condition' => [
                    'source' => 'company.registration_age',
                    'operator' => '>',
                    'value' => 12,
                ],
                'thresholds' => [
                    100000000 => 3,
                    10000000  => 0,
                    0         => -1,
                ],
            ],

            'employees' => [
                'source' => 'company.employees',
                'condition' => [
                    'source' => 'company.exists',
                    'operator' => '==',
                    'value' => true,
                ],
                'thresholds' => [
                    11 => 5,
                    6  => 3,
                    2  => 2,
                    0  => 0,
                ],
            ],

            'reviews' => [
                'source' => 'reviews.average',
                'condition' => [
                    'source' => 'reviews.count',
                    'operator' => '>',
                    'value' => 2,
                ],
                'thresholds' => [
                    4.85 => 7,
                    4.70 => 4,
                    4.40 => 1,
                    4.10 => -3,
                    3.90 => -6,
                    3.65 => -10,
                    0    => -15,
                ],
            ],

            'fake_reviews' => [
                'source' => 'reviews.fake_count',
                'condition' => [
                    'source' => 'reviews.count',
                    'operator' => '>',
                    'value' => 0,
                ],
                'thresholds' => [
                    5 => -7,
                    3 => -4,
                    2 => -2,
                    1 => -1,
                    0 => 0,
                ],
            ],

            'offices' => [
                'source' => 'offices.count',
                'thresholds' => [
                    7 => 10,
                    6 => 9,
                    5 => 7,
                    4 => 5,
                    3 => 3,
                    2 => 2,
                    1 => 0,
                    0 => 0,
                ],
            ],

            'unique_content' => [
                'source' => 'ads.unique_ratio',
                'condition' => [
                    'source' => 'ads.count',
                    'operator' => '>',
                    'value' => 0,
                ],
                'thresholds' => [
                    90 => 2,
                    75 => 1,
                    50 => 0,
                    15 => -2,
                    0 => -5,
                ],
            ],

            'response_time' => [
                'source' => 'response_time',
                'thresholds' => [
                    40 => -2,
                    20 => 0,
                    5  => 1,
                    0  => 3,
                ],
            ],

            // Реестр майнеров
            'registry' => [
                'source' => 'registry.exists',
                'condition' => [
                    'source' => 'hosting.exists',
                    'operator' => '==',
                    'value' => true,
                ],
                'penalty' => -5,
                'bonus' => 15,
            ],

            // Возможность посещения территории хостинга
            'visiting_territory' => [
                'source' => 'hosting.visiting_territory',
                'condition' => [
                    'source' => 'hosting.exists',
                    'operator' => '==',
                    'value' => true,
                ],
                'penalty' => -5,
            ],
        ],

        'directions' => [
            'miners' => [

                'capital' => [
                    'source' => 'company.capital',
                    'condition' => [
                        'source' => 'company.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    'thresholds' => [
                        5000000 => 6,
                        1000000 => 3,
                        100000  => 1,
                        20000   => 0,
                        0       => -2,
                    ],
                ],

                'income' => [
                    'source' => 'company.income',
                    'condition' => [
                        'source' => 'company.registration_age',
                        'operator' => '>',
                        'value' => 12,
                    ],
                    'thresholds' => [
                        10000000000 => 7,
                        5000000000  => 5,
                        2000000000  => 3,
                        1000000000  => 0,
                        100000000   => -3,
                        0           => -6,
                    ],
                ],

                'employees' => [
                    'source' => 'company.employees',
                    'condition' => [
                        'source' => 'company.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    'thresholds' => [
                        50 => 7,
                        20 => 5,
                        6  => 3,
                        2  => 1,
                        0  => -4,
                    ],
                ],
            ],

            'hosting' => [

                'capital' => [
                    'source' => 'company.capital',
                    'condition' => [
                        'source' => 'company.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    'thresholds' => [
                        10000000 => 5,
                        2000000  => 3,
                        300000   => 0,
                        20000    => -2,
                        0        => -8,
                    ],
                ],

                'income' => [
                    'source' => 'company.income',
                    'condition' => [
                        'source' => 'company.registration_age',
                        'operator' => '>',
                        'value' => 12,
                    ],
                    'thresholds' => [
                        5000000000 => 8,
                        500000000  => 5,
                        100000000  => 2,
                        30000000   => -4,
                        0          => -10,
                    ],
                ],

                'employees' => [
                    'source' => 'company.employees',
                    'condition' => [
                        'source' => 'company.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    'thresholds' => [
                        50 => 6,
                        20 => 4,
                        6  => 2,
                        2  => -2,
                        0  => -6,
                    ],
                ],

                'registry' => [
                    'source' => 'registry.exists',
                    'condition' => [
                        'source' => 'hosting.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    'penalty' => -20,
                    'bonus' => 10,
                ],

                'visiting_territory' => [
                    'source' => 'hosting.visiting_territory',
                    'condition' => [
                        'source' => 'hosting.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    'penalty' => -10,
                ],
            ],

            'legals' => [],
            'containers' => [],
            'noiseboxes' => [],
            'cryptoboilers' => [],
            'firmwares' => [],
            'gpus' => [],
            'service' => [],
            'exchanger' => [],
        ],
    ],
];
