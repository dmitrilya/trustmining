<?php

return [
    'notifications' => [
        'enabled' => 'Enabled',
        'directions' => [
            'email' => 'Email',
            'tg' => 'Telegram',
        ],
        'settings' => [
            'frequency' => [
                'name' => 'Frequency',
                'first' => 'Only the first one in a day',
                'all' => 'All',
                '12h' => 'Every 12 hours',
                'd' => 'Daily',
                '3d' => 'Every 3 days',
                'change' => 'On difficulty change',
            ],
            'condition' => [
                'name' => 'Condition',
                'drop' => 'Decrease only',
                'changing' => 'Any change',
                'negative' => 'Only negative',
                'all' => 'All',
            ]
        ]
    ],
];
