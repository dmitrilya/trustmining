<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is utilized to write
    | messages to your logs. The value provided here should match one of
    | the channels present in the list of "channels" configured below.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Laravel
    | utilizes the Monolog PHP logging library, which includes a variety
    | of powerful log handlers and formatters that you're free to use.
    |
    | Available drivers: "single", "daily", "monthly", "slack", "syslog",
    |                    "errorlog", "monolog", "custom", "stack"
    |
    */

    'channels' => [
        'trustfactor' => [
            'driver' => 'single',
            'path' => storage_path('logs/trustfactor.log'),
            'level' => 'info',
        ],

        'art' => [
            'driver' => 'single',
            'path' => storage_path('logs/art.log'),
            'level' => 'info',
        ],

        'forum-generate' => [
            'driver' => 'single',
            'path' => storage_path('logs/forum_generate.log'),
            'level' => 'info',
        ],

        'analytics' => [
            'driver' => 'single',
            'path' => storage_path('logs/analytics.log'),
            'level' => 'info',
        ],

        'socials-auth' => [
            'driver' => 'single',
            'path' => storage_path('logs/socials_auth.log'),
            'level' => 'info',
        ],

        'forum-score' => [
            'driver' => 'single',
            'path' => storage_path('logs/forum_score.log'),
            'level' => 'info',
        ],

        'moderation' => [
            'driver' => 'single',
            'path' => storage_path('logs/moderation.log'),
            'level' => 'info',
        ],

        'forum-question' => [
            'driver' => 'single',
            'path' => storage_path('logs/forum_question.log'),
            'level' => 'info',
        ],

        'agents' => [
            'driver' => 'single',
            'path' => storage_path('logs/agents.log'),
            'level' => 'info',
        ],

        'unknownalgo' => [
            'driver' => 'single',
            'path' => storage_path('logs/unknownalgo.log'),
            'level' => 'info',
        ],

        'integration-errors' => [
            'driver' => 'single',
            'path' => storage_path('logs/integration_errors.log'),
            'level' => 'info',
        ],

        'price-updating-errors' => [
            'driver' => 'single',
            'path' => storage_path('logs/price_updating_errors.log'),
            'level' => 'info',
        ],

        'price-updating-check' => [
            'driver' => 'single',
            'path' => storage_path('logs/price_updating_check.log'),
            'level' => 'info',
        ],

        'stack' => [
            'driver' => 'stack',
            'channels' => explode(',', (string) env('LOG_STACK', 'single')),
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'max_files' => env('LOG_DAILY_DAYS', 14),
            'replace_placeholders' => true,
        ],

        'monthly' => [
            'driver' => 'monthly',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'max_files' => 3,
            'replace_placeholders' => true,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => env('LOG_SLACK_USERNAME', env('APP_NAME', 'Laravel')),
            'emoji' => env('LOG_SLACK_EMOJI', ':boom:'),
            'level' => env('LOG_LEVEL', 'critical'),
            'replace_placeholders' => true,
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://' . env('PAPERTRAIL_URL') . ':' . env('PAPERTRAIL_PORT'),
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'handler_with' => [
                'stream' => 'php://stderr',
            ],
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER),
            'replace_placeholders' => true,
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

    ],

];
