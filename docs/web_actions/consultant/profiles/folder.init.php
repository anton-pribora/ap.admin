<?php

use ApCode\Html\Element\A;

PathAlias()->append('~/', basename(__DIR__) .'/');

Layout()->setVar('title', 'Пользователи');
Layout()->append('breadcrumbs', new A('Пользователи', ShortUrl(__dir('/'))));