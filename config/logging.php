<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'daily'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'permission' => 0777,

        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
            'permission' => 0777,

        ],

        'tx-deposit' => [
            'driver' => 'daily',
            'path' => storage_path('logs/cashless/consumer/tx-deposit.log'),
            'level' => 'debug',
            'days' => 14,
            'permission' => 0777,

        ],

        'tx-payment' => [
            'driver' => 'daily',
            'path' => storage_path('logs/cashless/consumer/tx-deposit.log'),
            'level' => 'debug',
            'days' => 14,
            'permission' => 0777,

        ],

        'sms-send' => [
            'driver' => 'daily',
            'path' => storage_path('logs/cashless/sms/send-sms.log'),
            'level' => 'debug',
            'days' => 14,
            'permission' => 0777,

        ],
        't-pesa-log' => [
            'driver' => 'daily',
            'path' => storage_path('logs/cashless/tpesa/processing.log'),
            'level' => 'debug',
            'days' => 14,
            'permission' => 0777,

        ],
        't-pesa-topup' => [

            'driver' => 'daily',
            'path' => storage_path('logs/cashless/tpesa/t-pesa-topup.log'),
            'level' => 'debug',
            'days' => 14,
            'permission' => 0777,

        ],
        'tx-agent-deposit' => [
            'driver' => 'daily',
            'path' => storage_path('logs/cashless/agent/tx-agent-deposit.log'),
            'level' => 'debug',
            'days' => 14,
            'permission' => 0777,

        ],
        'exceptions'=>[

            'driver'=>'single',
            'path'=>storage_path('logs/cashless/exceptions.log')
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

];
