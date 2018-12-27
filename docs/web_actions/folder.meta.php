<?php

return [
    'menu' => [
        ['text' => 'Главная', 'url' => ShortUrl(__dir('/')), 'active' => Request()->action() == ExpandUrl('@root/index.php')],
        ['text' => 'Войти', 'position' => 'left', 'url' => ShortUrl(__dir('/consultant/')), 'active' => Request()->matchAction('/consultant/')],
    ],
];