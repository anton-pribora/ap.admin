<?php

return [
    'menu' => [
        ['text' => Icon('profiles') .' Пользователи'   , 'url' => ShortUrl(__dir('profiles/')), 'submenu' => [
            ['text' => Icon('search') . ' Все', 'url' => ShortUrl(__dir('profiles/all/'))],
            ['text' => Icon('add') . ' Добавить нового', 'url' => ShortUrl(__dir('profiles/new/'))],
        ]],
        ['text' => '<i class="fa fa-fw fa-cogs"></i> Разработка', 'url' => ShortUrl(__dir('development/')), 'submenu' => [
            ['text' => '<i class="fa fa-fw fa-calendar-check-o"></i> Планы', 'url' => ShortUrl(__dir('development/plan/')),],
            ['text' => '<i class="fa fa-fw fa-envelope-o"></i> Тест почты', 'url' => ShortUrl(__dir('development/mailtest/')),],
            ['text' => Icon('tools') .' Инструменты', 'url' => ShortUrl(__dir('development/tools/')), 'submenu' => [
                ['text' => '<i class="fa fa-fw fa-cog"></i> Генератор классов', 'url' => ShortUrl(__dir('development/tools/billetgen/'))],
                ['text' => '<i class="fa fa-fw fa-television"></i> phpinfo()', 'url' => ShortUrl(__dir('development/tools/phpinfo.php'))],
                ['text' => '<i class="fa fa-fw fa-hdd-o"></i> Свободное место', 'url' => ShortUrl(__dir('development/tools/df.php'))],
            ]],
        ]],
    ],
    
    'usermenu' => [
        ['title' => Icon('profile') .' Мой профиль' , 'url' => ShortUrl('@consultant/profiles/all/profile/')],
        false,
        ['title' => '<i class="fa fa-power-off fa-fw"></i> Выйти', 'url' => ShortUrl('@root/consultant/logout/')],
    ],
];