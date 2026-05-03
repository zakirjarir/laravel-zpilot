<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Installer Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the installer settings.
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
