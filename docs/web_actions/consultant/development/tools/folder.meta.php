<?php

return [
    'nav' => [
        ['title' => 'Тест почты', 'href' => ShortUrl(__DIR__ . '/mailtest/'), 'active' => Request()->matchAction(ExpandUrl(__dir('mailtest/')))],
        ['title' => 'Генератор классов', 'href' => ShortUrl(__DIR__ . '/billetgen/'), 'active' => Request()->matchAction(ExpandUrl(__dir('billetgen/')))],
        ['title' => 'Генератор разделов', 'href' => ShortUrl(__DIR__ . '/partgen/'), 'active' => Request()->matchAction(ExpandUrl(__dir('partgen/')))],
        ['title' => 'phpinfo()', 'href' => ShortUrl(__DIR__ . '/phpinfo.php'), 'active' => Request()->action() == ExpandUrl(__dir('phpinfo.php'))],
        ['title' => 'Свободное место', 'href' => ShortUrl(__DIR__ . '/df.php'), 'active' => Request()->action() == ExpandUrl(__dir('df.php'))],
    ],
];
