<?php

return [
    'nav' => [
        ['title' => 'Генератор разделов', 'href' => ShortUrl(__DIR__ . '/partgen/'), 'active' => Request()->matchAction(ExpandUrl(__dir('partgen/')))],
        ['title' => 'Генератор виджетов', 'href' => ShortUrl(__DIR__ . '/widgetgen/'), 'active' => Request()->matchAction(ExpandUrl(__dir('widgetgen/')))],
        ['title' => 'phpinfo()', 'href' => ShortUrl(__DIR__ . '/phpinfo.php'), 'active' => Request()->action() == ExpandUrl(__dir('phpinfo.php'))],
        ['title' => 'Свободное место', 'href' => ShortUrl(__DIR__ . '/df.php'), 'active' => Request()->action() == ExpandUrl(__dir('df.php'))],
    ],
];
