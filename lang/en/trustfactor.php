<?php

return [
    'directions' => [
        'miners' => 'Sale of mining equipment',
        'legals' => 'Legal services',
        'containers' => 'Container trading',
        'cryptoboilers' => 'Crypto boiler trading',
        'noiseboxes' => 'Noise box manufacturing',
        'firmwares' => 'Software development',
        'gpus' => 'Sale of gas-piston power plants',
        'hosting' => 'Mining hotel',
        'service' => 'Equipment repair',
        'exchanger' => 'Cryptocurrency exchange',
    ],

    'factors' => [
        'company_exists' => [
            'title' => 'Company verification',
            'description' => 'The seller has confirmed the company through government registries',
        ],
        'legal_entity' => [
            'title' => 'Legal entity',
            'description' => 'The company is registered as a legal entity',
        ],
        'company_status' => [
            'title' => 'Company status',
            'description' => 'The company is active according to official registries',
        ],
        'branches' => [
            'title' => 'Branches',
            'description' => 'The company has officially registered branches',
        ],
        'risk_factors' => [
            'title' => 'Risk factors',
            'description' => 'Indicators of unfair business practices by the company or its management',
            'none' => 'None detected',

            'components' => [
                'ЕФРСБ' => [
                    'title' => 'Bankruptcy registry',
                    'description' => 'Presence of bankruptcy-related arbitration cases',
                ],
                'НедобПост' => [
                    'title' => 'Unreliable suppliers registry',
                    'description' => 'Indicator of inclusion in the unreliable suppliers registry',
                ],
                'ДисквЛица' => [
                    'title' => 'Disqualified executives',
                    'description' => 'Indicator of disqualified persons in the company’s management',
                ],
                'МассРуковод' => [
                    'title' => 'Mass executives',
                    'description' => 'Indicator of mass executives',
                ],
                'МассУчред' => [
                    'title' => 'Mass founders',
                    'description' => 'Indicator of mass founders',
                ],
                'НелегалФин' => [
                    'title' => 'Illegal financial activity',
                    'description' => 'Indicator of illegal activity in the financial market according to the Central Bank of the Russian Federation',
                ],
                'Санкции' => [
                    'title' => 'Sanctions lists',
                    'description' => 'Indicator of inclusion in sanctions lists',
                ],
                'СанкцУчр' => [
                    'title' => 'Sanctions against the founder',
                    'description' => 'Sanctions imposed on the founder',
                ],
            ],
        ],
        'registry' => [
            'title' => 'Federal Tax Service mining registry',
            'description' => 'The company is listed in the mining operators registry',
        ],
        'visiting_territory' => [
            'title' => 'Hosting site access',
            'description' => 'The company allows visits to the hosting facility',
        ],
        'registration_age' => [
            'title' => 'Company age',
            'description' => 'Time elapsed since the company’s registration',
        ],
        'website' => [
            'title' => 'Official website',
            'description' => 'Presence and quality of the company’s official website',

            'components' => [
                'https' => [
                    'title' => 'Secure connection',
                    'description' => 'The website uses a secure HTTPS connection',
                ],
                'reachable' => [
                    'title' => 'Website availability',
                    'description' => 'The website is accessible and responds to requests',
                ],
                'domain_age' => [
                    'title' => 'Domain age',
                    'description' => 'How long the official website’s domain has existed',
                ],
                'company_info' => [
                    'title' => 'Company information',
                    'description' => 'Detailed information about the company and its activities is published on the website',
                ],
                'contacts' => [
                    'title' => 'Contact information',
                    'description' => 'Contact details for reaching the company are provided on the website',
                ],
            ],
        ],
        'phone' => [
            'title' => 'Phone number',
            'description' => 'The company has provided a phone number',

            'components' => [
                'actual' => [
                    'title' => 'Valid phone number',
                    'description' => 'Calls to this number are successfully connected',
                ],
                'toll_free' => [
                    'title' => 'Toll-free call (8800)',
                    'description' => 'Calls to this number are free (toll-free)',
                ],
            ],
        ],
        'video' => [
            'title' => 'Company video',
            'description' => 'The company has posted a video',
        ],
        'images' => [
            'title' => 'Company photos',
            'description' => 'Photos increase transparency',
        ],
        'reviews' => [
            'title' => 'Customer reviews',
            'description' => 'Average rating based on verified reviews',
        ],
        'fake_reviews' => [
            'title' => 'Fake reviews',
            'description' => 'Artificial or fraudulent reviews have been detected',
        ],
        'offices' => [
            'title' => 'Verified offices',
            'description' => 'Confirmed office locations increase trust',
        ],
        'unique_content' => [
            'title' => 'Unique content',
            'description' => 'Unique images and descriptions increase credibility',
        ],
        'response_time' => [
            'title' => 'Average response time',
            'description' => 'How quickly the seller responds to messages',
        ],
        'income' => [
            'title' => 'Official revenue',
            'description' => 'Revenue according to financial statements',
        ],
        'profit' => [
            'title' => 'Non-negative profit',
            'description' => 'The company’s official profit is positive',
        ],
        'capital' => [
            'title' => 'Authorized capital',
            'description' => 'Officially confirmed authorized capital of the company',
        ],
        'employees' => [
            'title' => 'Number of employees',
            'description' => 'Only officially registered employees are counted',
        ],
    ],
];
