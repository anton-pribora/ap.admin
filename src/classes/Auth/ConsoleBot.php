<?php

namespace Auth;

use Project\Profile;

class ConsoleBot extends Profile
{
    protected $data = [
        'id'   => '-1',
        'meta' => [
            'name' => [
                'first' => 'ConsoleBot'
            ],
            'roles' => ['consultant', 'admin']
        ]
    ];
}
