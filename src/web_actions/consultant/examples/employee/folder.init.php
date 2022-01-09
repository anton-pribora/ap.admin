<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', 'Сотрудники компании');
Layout()->append('breadcrumbs', new A('Сотрудники компании', ShortUrl(__dir('/'))));
