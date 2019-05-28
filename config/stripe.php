<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "array"
    |
    */

    'api_key_publishable' => env('STRIPE_API_KEY_PUBLISHABLE', 'nope'),
    'api_key_secret' => env('STRIPE_API_KEY_SECRET', 'nope'),
];