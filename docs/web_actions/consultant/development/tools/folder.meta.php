<?php

return [
    'nav' => [
        ['title' => 'Генератор классов', 'href' => ShortUrl(__DIR__ .'/billetgen/'), 'active' => Request()->matchAction(ExpandUrl(__DIR__ .'/billetgen/'))],
        ['title' => 'phpinfo()', 'href' => ShortUrl(__DIR__ .'/phpinfo.php'), 'active' => Request()->action() == ExpandUrl(__dir('phpinfo.php'))],
        ['title' => 'Свободное место', 'href' => ShortUrl(__DIR__ .'/df.php'), 'active' => Request()->action() == ExpandUrl(__dir('df.php'))],
    ],
];