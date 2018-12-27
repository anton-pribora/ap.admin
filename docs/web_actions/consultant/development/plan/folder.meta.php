<?php

return [
    'nav' => [
        ['title' => 'Планы', 'href' => ShortUrl(__dir('index.php')), 'active' => Request()->action() == ExpandUrl(__dir('index.php'))],
    ],
];