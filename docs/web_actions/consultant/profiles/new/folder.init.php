<?php

use ApCode\Html\Element\A;

PathAlias()->append('~/', basename(__DIR__) .'/');

Layout()->setVar('title', 'Добавить пользователя');
Layout()->append('breadcrumbs', new A('Добавить нового', ShortUrl(__DIR__ .'/')));