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
        'name'   => 'main-bs4',  // default template name
        'layout' => [
            'main'  => 'main',
            'login' => 'login',  // see module/auth/exec/login.php
            'mail'  => 'mail',
            'pdf'   => 'pdf',
            'error' => 'error',
        ],
        'login' => [
            'template' => 'admin-bs3',
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
        'defaultEmail' => 'default@email',
        'transports'   => [
            [
                'type' => 'file',
                'dir'  => ROOT_DIR . '/../mails/'. date('Y-m/d/'),
            ],
        ],
    ],
    
    'cdn' => [
        'url' => '/cdn/cache/',
    ],
    
    'file' => [
        'uploads'    => ROOT_DIR . '/uploads/',
        'thumbnails' => ROOT_DIR . '/public/thumbnails/',
    ],
]);