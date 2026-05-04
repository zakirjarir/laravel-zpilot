<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel ZPilot Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the ZPilot settings.
    |
    */

    'requirements' => [
        'php' => [
            'version' => '8.1.0',
        ],
        'extensions' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'xml',
            'ctype',
            'json',
        ],
    ],

    'permissions' => [
        'storage/'           => '775',
        'bootstrap/cache/'   => '775',
    ],

];
