<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', 'Пользователи');
Layout()->append('breadcrumbs', new A('Пользователи', ShortUrl(__dir('/'))));
