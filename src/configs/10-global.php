<?php

Config()->setup([
    'project' => [
        'name' => 'Ap.admin',
        'logo' => '<i class="bi bi-tools" style="font-size: 1.3rem;"></i>',
        'help' => 'help@example.com',
    ],

    'server' => [
        'webroot'    => '@root/web_docroot',
        'webactions' => '@root/web_actions',
    ],

    'db' => [
        'dsn'      => 'mysql:dbname=ap_admin;host=db;charset=utf8',
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
        'developer_uid' => 1000,
        '_SERVER'       => [
            'HTTPS'       => 'on',
            'SERVER_PORT' => '443',
            'SERVER_NAME' => 'ap.admin',
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

    'js' => [
        'ENV' => getenv('APPLICATION_ENV') === 'development' ? 'dev' : 'prod',  // Vue 3 extension (used by module misc vue3)
    ],
]);
