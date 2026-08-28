<?php

return [
    'rating' => [
        'asics' => [
            'title' => 'Top ASICs: the best miners in :year',
            'description' => 'Current ASIC ratings. Compare equipment by daily profitability or return on investment speed on the Trust Mining website',
            'header' => 'ASIC Ratings',
            'breadcrumb' => 'Top ASICs',

            'types' => [
                'profit' => [
                    'title' => 'Top most profitable ASICs for today',
                    'description' => 'Daily updated rating of ASIC miners by net profit. Profitability calculator, current prices, specifications, and top high-yield models.',
                    'header' => 'Best mining equipment by profit',
                    'title_prefix' => 'profitable',
                    'header_prefix' => 'by profit',
                    'best_prefix' => 'profitable',
                    'breadcrumb' => 'Profit',
                    'best' => 'The most profitable ASIC at the moment'
                ],
                'payback' => [
                    'title' => 'Top most cost-effective ASICs for today',
                    'description' => 'Rating of ASICs by investment payback speed. Find out which mining equipment will return investments fastest, taking into account current cryptocurrency rates.',
                    'header' => 'Best mining equipment by payback speed',
                    'title_prefix' => 'cost-effective',
                    'header_prefix' => 'by payback speed',
                    'best_prefix' => 'fastest-payback',
                    'breadcrumb' => 'Payback',
                    'best' => 'The fastest-payback ASIC at the moment'
                ]
            ],

            'filters' => [
                'best' => 'The :prefix ASIC at the moment',

                'algorithm' => [
                    'title' => 'The most :prefix ASICs on :filter_value for today',
                    'description' => 'Fresh rating of ASIC miners on the :filter_value algorithm :prefix. Comparison of model profitability, technical parameters, energy efficiency, and equipment prices.',
                    'header' => 'Best :filter_value mining equipment :prefix',
                    'breadcrumb' => ':filter_value',
                ],
                'coin' => [
                    'title' => 'The most :prefix ASICs for mining :filter_value for today',
                    'description' => 'Rating of the best equipment for mining :filter_value crypto coin :prefix. Comparison of hash rate, power consumption, and daily net profit of popular ASIC models.',
                    'header' => 'Best equipment for mining :filter_value :prefix',
                    'breadcrumb' => 'For :filter_value',
                ],
                'price' => [
                    'title' => 'The most :prefix ASICs up to :filter_value rubles for today',
                    'description' => 'Catalog and rating of ASIC miners costing up to :filter_value rubles :prefix. Choose budget-friendly and efficient mining equipment for your starting capital.',
                    'header' => 'Best mining equipment up to :filter_value rubles :prefix',
                    'breadcrumb' => 'Up to :filter_value rubles',
                ],
                'cooling' => [
                    'air' => [
                        'title' => 'air',
                        'description' => 'air',
                        'header' => 'air',
                        'breadcrumb' => 'Air cooling',
                    ],
                    'hydro' => [
                        'title' => 'hydro',
                        'description' => 'water',
                        'header' => 'water',
                        'breadcrumb' => 'Water cooling',
                    ],
                    'immersion' => [
                        'title' => 'immersion',
                        'description' => 'immersion',
                        'header' => 'immersion',
                        'breadcrumb' => 'Immersion cooling',
                    ],
                    'title' => 'The most :prefix :filter_value ASICs for today',
                    'description' => 'Comparison and rating of ASIC miners with :filter_value cooling :prefix. Operating features, noise level, energy efficiency, and current profitability of models.',
                    'header' => 'Best mining equipment with :filter_value cooling :prefix'
                ],
                'home' => [
                    'title' => 'The most :prefix home ASICs for today',
                    'description' => 'Rating of the best quiet ASIC miners for home use :prefix. Comparison of models by noise level, power consumption from a 220V outlet, and payback.',
                    'header' => 'Best mining equipment for home placement :prefix',
                    'breadcrumb' => 'Home ASICs',
                ],
                'new' => [
                    'title' => 'The most :prefix new ASICs for today',
                    'description' => 'Review and rating of new ASIC miners on the market :prefix. The latest and most high-tech equipment from Bitmain, Whatsminer, Avalon with maximum energy efficiency.',
                    'header' => 'Best new mining equipment :prefix',
                    'breadcrumb' => 'New ASICs',
                ]
            ]
        ]
    ]
];
