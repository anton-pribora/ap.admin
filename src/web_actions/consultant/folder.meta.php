<?php

return [
    'menu' => [
        ['text' => 'Примеры страниц', 'url' => ShortUrl('@consultant/examples/'), 'submenu' => [
            ['text' => 'Планктошки', 'url' => ShortUrl('@consultant/examples/plankton/')],
            ['text' => 'Сотрудники', 'url' => ShortUrl('@consultant/examples/employee/')],
            ['text' => 'Пустая страница', 'url' => ShortUrl('@consultant/examples/blank.php')],
            ['text' => 'Страница с текстом', 'url' => ShortUrl('@consultant/examples/text.php')],
        ]],
        ['text' => 'Инструменты', 'url' => ShortUrl('@consultant/tools/'), 'submenu' => [
            ['text' => 'Тест почты', 'url' => ShortUrl(__dir('development/tools/mailtest/')),],
            ['text' => 'Генератор разделов', 'url' => ShortUrl(__dir('development/tools/partgen/'))],
            ['text' => 'phpinfo()', 'url' => ShortUrl(__dir('development/tools/phpinfo.php'))],
            ['text' => 'Свободное место', 'url' => ShortUrl(__dir('development/tools/df.php'))],
        ]]
    ],

    'usermenu' => [
        ['text' => Icon('profile') . 'Мой профиль' , 'url' => ShortUrl('@consultant/profiles/all/profile/')],
        false,
        ['text' => '<i class="bi bi-box-arrow-right me-1"></i>Выйти', 'url' => ShortUrl('@root/consultant/logout/')],
    ],

    'additionalmenu' => [
        ['text' => 'Тест почты', 'url' => ShortUrl(__dir('development/tools/mailtest/')),],
        ['text' => 'Генератор разделов', 'url' => ShortUrl(__dir('development/tools/partgen/'))],
        ['text' => 'phpinfo()', 'url' => ShortUrl(__dir('development/tools/phpinfo.php'))],
        ['text' => 'Свободное место', 'url' => ShortUrl(__dir('development/tools/df.php'))],
    ],
];
