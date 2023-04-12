<?php

// Контроль видимости разделов меню
$visible = function ($section) {
    return Identity()->getPermit($section) === true;
};

return [
    'menu' => [
        ['text' => 'Примеры страниц', 'visible' => $visible('examples'), 'url' => ShortUrl('@consultant/examples/'), 'submenu' => [
            ['text' => 'Планктошки', 'visible' => $visible('examples'), 'url' => ShortUrl('@consultant/examples/plankton/')],
            ['text' => 'Сотрудники', 'visible' => $visible('examples'), 'url' => ShortUrl('@consultant/examples/employee/')],
            ['text' => 'Пустая страница', 'visible' => $visible('examples'), 'url' => ShortUrl('@consultant/examples/blank.php')],
            ['text' => 'Страница с текстом', 'visible' => $visible('examples'), 'url' => ShortUrl('@consultant/examples/text.php')],
        ]],
        ['text' => 'Инструменты', 'visible' => $visible('tools'), 'url' => ShortUrl('@consultant/tools/'), 'submenu' => [
            ['text' => 'Тест почты', 'visible' => $visible('tools'), 'url' => ShortUrl(__dir('development/tools/mailtest/')),],
            ['text' => 'Генератор разделов', 'visible' => $visible('tools'), 'url' => ShortUrl(__dir('development/tools/partgen/'))],
            ['text' => 'Генератор виджетов', 'visible' => $visible('tools'), 'url' => ShortUrl(__dir('development/tools/widgetgen/'))],
            ['text' => 'phpinfo()', 'visible' => $visible('tools'), 'url' => ShortUrl(__dir('development/tools/phpinfo.php'))],
            ['text' => 'Свободное место', 'visible' => $visible('tools'), 'url' => ShortUrl(__dir('development/tools/df.php'))],
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
        ['text' => 'Генератор виджетов', 'url' => ShortUrl(__dir('development/tools/widgetgen/'))],
        ['text' => 'phpinfo()', 'url' => ShortUrl(__dir('development/tools/phpinfo.php'))],
        ['text' => 'Свободное место', 'url' => ShortUrl(__dir('development/tools/df.php'))],
    ],
];
