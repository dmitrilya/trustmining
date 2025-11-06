<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'yandexgpt' => [
        'folder' => env('YANDEXGPT_FOLDER_ID'),
        'id' => env('YANDEXGPT_APP_ID'),
        'key' => env('YANDEXGPT_APP_KEY'),
    ],

    'tgbot' => [
        'token' => env('NOTIFICATION_BOT_TOKEN'),
    ],

    'coinmarketcap' => [
        'key' => env('COINMARKETCAP_APP_KEY')
    ],

    'coingecko' => [
        'key' => env('COINGECKO_APP_KEY')
    ],

    'tinkoff' => [
        'account_number' => env('TINKOFF_ACCOUNT_NUMBER'),
        'terminal' => [
            'key' => env('TINKOFF_TERMINAL_KEY'),
            'password' => env('TINKOFF_TERMINAL_PASSWORD')
        ],
        'key' => env('TINKOFF_API_KEY')
    ],

    'amocrm' => [
        'channel' => [
            'id' => env('AMOCRM_CHANNEL_ID'),
            'secret_key' => env('AMOCRM_CHANNEL_SECRET_KEY'),
            'bot_id' => env('AMOCRM_CHANNEL_BOT_ID'),
        ],
        'integration' => [
            'id' => env('AMOCRM_INTEGRATION_ID'),
            'token' => env('AMOCRM_INTEGRATION_TOKEN'),
        ]
    ]
];
