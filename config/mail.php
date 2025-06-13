<?php

return [

    // 1) Use the MAIL_MAILER from .env, default to SMTP
    'default' => env('MAIL_MAILER', 'smtp'),

    // 2) Define each mail “transport”
    'mailers' => [
        'smtp' => [
            'transport'    => 'smtp',
            'host'         => env('MAIL_HOST', 'smtp.gmail.com'),
            'port'         => env('MAIL_PORT', 587),
            'encryption'   => env('MAIL_ENCRYPTION', 'tls'),
            'username'     => env('MAIL_USERNAME'),
            'password'     => env('MAIL_PASSWORD'),
            'timeout'      => null,
            // explicitly allow LOGIN/PLAIN (default)
            'auth_mode'    => null,
        ],

        // fallback log-driver (good to have for local debug)
        'log' => [
            'transport' => 'log',
            'channel'   => env('MAIL_LOG_CHANNEL'),
        ],

        // you can leave other transports here...
        'array' => [
            'transport' => 'array',
        ],
    ],

    // 3) The “From:” header on all outgoing mail
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'felizxcoder@gmail.com'),
        'name'    => env('MAIL_FROM_NAME', 'NCK Helper'),
    ],

    // no global “reply_to” section unless you need it
];
