<?php

return [
    'nav' => [
        ['title' => 'Пользователь', 'href' => ShortUrl(__dir()), 'active' => Request()->action() == ExpandUrl(__dir('index.php'))],
    ],
];