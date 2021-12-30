<?php

Layout()->setVar('title', 'phpinfo()');

ob_start();
phpinfo();

echo preg_replace([
    '/(body|hr|h\d)\s+\{[^}]+\}/i',
    '/a:\w+\s+\{[^}]+\}/i'
], '/*$0*/', ob_get_clean());
