<?php

Config()->setup([
    'server' => [
        'webroot'    => '@root/web_docroot',
        'webactions' => '@root/web_actions',
    ],

    'db' => [
        'dsn'      => 'mysql:dbname=basesystem;host=localhost;charset=utf8',
        'login'    => 'test',
        'password' => 'test',
    ],

    'template' => [
        'name'   => 'public-bs5',  // default template name
        'layout' => [
            'main'  => 'main',
            'error' => 'main',
        ],
        'login' => [
            'template' => 'admin-bs5',
            'layout'   => 'login',
        ],
    ],

    'console' => [
        '_SERVER' => [
            'HTTPS'       => 'on',
            'SERVER_PORT' => '443',
            'SERVER_NAME' => 'admin.pribora.info',
            'REQUEST_URI' => '/',
        ],
    ],

    'mail' => [
        'defaultFrom' => 'default@email',
        'transports'  => [
            [
                'type' => 'file',
                'dir'  => ROOT_DIR . '/../mails/'. date('Y-m/d/'),
            ],
        ],
    ],

    'file' => [
        'uploads'    => ROOT_DIR . '/uploads/',
        'thumbnails' => ROOT_DIR . '/public/thumbnails/',
    ],

    'js' => [
        'ENV' => 'prod',  // Vue 3 extension (used by module misc vue3)
    ],
]);
