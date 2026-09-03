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
            'firmwares' => 12,
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
            //'branches',
            'registration_age',
            'risk_factors',
            'legal_cases',
            'website',
            'video',
            'images',
            'capital',
            'income',
            'profit',
            'employees',
            'reviews',
            'fake_reviews',
            'offices',
            'unique_content',
            'response_time',
            'ignores',
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

            'registration_age' => [
                'source' => 'company.registration_age',
                'thresholds' => [
                    48 => 14,
                    36 => 11,
                    24 => 7,
                    18 => 3,
                    8  => 0,
                    0  => -3,
                ],
            ],

            'risk_factors' => [
                'type' => 'list',
                'source' => 'company.risks',

                'components' => [
                    'ЕФРСБ' => [
                        'score' => -30
                    ],
                    'НедобПост' => [
                        'score' => -6
                    ],
                    'ДисквЛица' => [
                        'score' => -8
                    ],
                    'МассРуковод' => [
                        'score' => -2
                    ],
                    'МассУчред' => [
                        'score' => -1
                    ],
                    'НелегалФин' => [
                        'score' => -6
                    ],
                    'Санкции' => [
                        'score' => -2
                    ],
                    'СанкцУчр' => [
                        'score' => -2
                    ],
                ]
            ],

            'legal_cases' => [
                'type' => 'threshold_reverse',
                'source' => 'legal_cases.ratio',
                'thresholds' => [
                    '2.5'  => -7,
                    '1.8'  => -5,
                    '1'    => -2,
                    '0.25' => 0,
                    '0'    => 1,
                ],
            ],

            'website' => [
                'type' => 'group',
                'source' => 'website.exists',
                'penalty' => -3,

                'components' => [
                    'https' => [
                        'source' => 'website.https',
                        'bonus' => 1,
                        'penalty' => -4,
                    ],

                    'reachable' => [
                        'source' => 'website.reachable',
                        'bonus' => 1,
                        'penalty' => -3,
                    ],
                ],
            ],

            'phone' => [
                'type' => 'group',
                'source' => 'phone.exists',

                'components' => [
                    'actual' => [
                        'source' => 'phone.actual',
                        'penalty' => -2,
                    ],

                    'toll_free' => [
                        'source' => 'phone.toll_free',
                        'bonus' => 2,
                    ]
                ]
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
                'conditions' => [
                    [
                        'source' => 'company.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    [
                        'source' => 'company.capital',
                        'operator' => '!=',
                        'value' => null,
                    ]
                ],
                'thresholds' => [
                    20000 => 2,
                    0     => 0,
                ],
            ],

            'income' => [
                'source' => 'company.income',
                'conditions' => [
                    [
                        'source' => 'company.registration_age',
                        'operator' => '>',
                        'value' => 12,
                    ]
                ],
                'thresholds' => [
                    1000000 => 3,
                    100000  => 0,
                    0       => -1,
                ],
            ],

            'profit' => [
                'source' => 'company.profit',
                'conditions' => [
                    [
                        'source' => 'company.registration_age',
                        'operator' => '>',
                        'value' => 12,
                    ]
                ],
                'thresholds' => [
                    -50000  => 0,
                    -300000  => -1,
                    -2000000 => -2,
                ],
            ],

            'employees' => [
                'source' => 'company.employees.count',
                'conditions' => [
                    [
                        'source' => 'company.exists',
                        'operator' => '==',
                        'value' => true,
                    ],
                    [
                        'source' => 'company.legal_entity',
                        'operator' => '==',
                        'value' => true,
                    ],
                    [
                        'source' => 'company.employees.exists',
                        'operator' => '==',
                        'value' => true,
                    ]
                ],
                'thresholds' => [
                    10 => 5,
                    5  => 3,
                    2  => 2,
                    0  => 0,
                ],
            ],

            'reviews' => [
                'source' => 'reviews.average',
                'conditions' => [
                    [
                        'source' => 'reviews.count',
                        'operator' => '>',
                        'value' => 2,
                    ]
                ],
                'thresholds' => [
                    '4.85' => 7,
                    '4.70' => 4,
                    '4.40' => 1,
                    '4.10' => -3,
                    '3.90' => -6,
                    '3.65' => -10,
                    '0'    => -15,
                ],
            ],

            'fake_reviews' => [
                'source' => 'reviews.fake_count',
                'conditions' => [
                    [
                        'source' => 'reviews.count',
                        'operator' => '>',
                        'value' => 0,
                    ]
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
                    3 => 4,
                    2 => 2,
                    0 => 0,
                ],
            ],

            'unique_content' => [
                'source' => 'ads.unique_ratio',
                'conditions' => [
                    [
                        'source' => 'ads.count',
                        'operator' => '>',
                        'value' => 0,
                    ]
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
                'source' => 'messages.response_time',
                'conditions' => [
                    [
                        'source' => 'messages.exists',
                        'operator' => '==',
                        'value' => true,
                    ]
                ],
                'thresholds' => [
                    40 => -2,
                    20 => 0,
                    5  => 1,
                    0  => 3,
                ],
            ],

            'ignores' => [
                'source' => 'ignore',
                'penalty' => -8,
            ],

            'registry' => [
                'source' => 'registry.exists',
                'conditions' => [
                    [
                        'source' => 'hosting.exists',
                        'operator' => '==',
                        'value' => true,
                    ]
                ],
                'penalty' => -5,
                'bonus' => 15,
            ],

            'visiting_territory' => [
                'source' => 'hosting.visiting_territory',
                'conditions' => [
                    [
                        'source' => 'hosting.exists',
                        'operator' => '==',
                        'value' => true,
                    ]
                ],
                'penalty' => -5,
            ],
        ],

        'directions' => [
            'miners' => [
                'capital' => [
                    'source' => 'company.capital',
                    'conditions' => [
                        [
                            'source' => 'company.exists',
                            'operator' => '==',
                            'value' => true,
                        ]
                    ],
                    'thresholds' => [
                        2000000 => 4,
                        500000 => 2,
                        100000  => 1,
                        20000   => 0,
                        0       => -2,
                    ],
                ],

                'income' => [
                    'source' => 'company.income',
                    'conditions' => [
                        [
                            'source' => 'company.registration_age',
                            'operator' => '>',
                            'value' => 12,
                        ]
                    ],
                    'thresholds' => [
                        1000000000 => 7,
                        150000000  => 5,
                        30000000  => 3,
                        10000000  => 0,
                        2000000   => -3,
                        0           => -6,
                    ],
                ],

                'employees' => [
                    'source' => 'company.employees.count',
                    'conditions' => [
                        [
                            'source' => 'company.exists',
                            'operator' => '==',
                            'value' => true,
                        ],
                        [
                            'source' => 'company.legal_entity',
                            'operator' => '==',
                            'value' => true,
                        ],
                        [
                            'source' => 'company.employees.exists',
                            'operator' => '==',
                            'value' => true,
                        ]
                    ],
                    'thresholds' => [
                        50 => 7,
                        20 => 5,
                        6  => 3,
                        2  => 1,
                        0  => -4,
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
                        0 => 0,
                    ],
                ],
            ],

            'hosting' => [
                'capital' => [
                    'source' => 'company.capital',
                    'conditions' => [
                        [
                            'source' => 'company.exists',
                            'operator' => '==',
                            'value' => true,
                        ]
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
                    'conditions' => [
                        [
                            'source' => 'company.registration_age',
                            'operator' => '>',
                            'value' => 12,
                        ]
                    ],
                    'thresholds' => [
                        50000000 => 8,
                        5000000  => 5,
                        1000000  => 2,
                        300000   => -4,
                        0          => -10,
                    ],
                ],

                'employees' => [
                    'source' => 'company.employees.count',
                    'conditions' => [
                        [
                            'source' => 'company.exists',
                            'operator' => '==',
                            'value' => true,
                        ],
                        [
                            'source' => 'company.legal_entity',
                            'operator' => '==',
                            'value' => true,
                        ],
                        [
                            'source' => 'company.employees.exists',
                            'operator' => '==',
                            'value' => true,
                        ]
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
                    'conditions' => [
                        [
                            'source' => 'hosting.exists',
                            'operator' => '==',
                            'value' => true,
                        ]
                    ],
                    'penalty' => -20,
                    'bonus' => 10,
                ],

                'visiting_territory' => [
                    'source' => 'hosting.visiting_territory',
                    'conditions' => [
                        [
                            'source' => 'hosting.exists',
                            'operator' => '==',
                            'value' => true,
                        ]
                    ],
                    'penalty' => -10,
                ],
            ],

            'legals' => [],
            'containers' => [],
            'noiseboxes' => [],
            'cryptoboilers' => [],
            'firmwares' => [
                'offices' => [
                    'source' => 'offices.count',
                    'thresholds' => [
                        2 => 2,
                        0 => 0,
                    ],
                ],
            ],
            'gpus' => [],
            'service' => [
                'offices' => [
                    'source' => 'offices.count',
                    'thresholds' => [
                        2 => 2,
                        0 => 0,
                    ],
                ],
            ],
            'exchanger' => [
                'offices' => [
                    'source' => 'offices.count',
                    'thresholds' => [
                        2 => 2,
                        0 => 0,
                    ],
                ],
            ],
        ],
    ],
];
