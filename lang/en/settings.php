<?php

return [
    'notifications' => [
        'on' => 'Enabled',
        'directions' => [
            'e' => 'Email',
            't' => 'Telegram',
        ],
        'settings' => [
            'f' => [
                'name' => 'Frequency',
                'f' => 'Only the first one in a day',
                'a' => 'All',
                '12h' => 'Every 12 hours',
                'd' => 'Daily',
                '3d' => 'Every 3 days',
                'c' => 'On difficulty change',
            ],
            'c' => [
                'name' => 'Condition',
                'd' => 'Decrease only',
                'c' => 'Any change',
                'n' => 'Only negative',
                'a' => 'All',
            ]
        ]
    ],
];
