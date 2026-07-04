<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'manajer' => [
            'driver' => 'session',
            'provider' => 'manajers',
        ],

        'sopir' => [
            'driver' => 'session',
            'provider' => 'sopirs',
        ],

        'owner' => [
            'driver' => 'session',
            'provider' => 'owners',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'manajers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Manajer::class,
        ],

        'sopirs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Sopir::class,
        ],

        'owners' => [
            'driver' => 'eloquent',
            'model' => App\Models\Owner::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
