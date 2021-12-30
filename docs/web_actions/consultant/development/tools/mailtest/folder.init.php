<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', 'Тест почты');
Layout()->append('breadcrumbs', new A('Тест почты', ShortUrl(__dir('/'))));
