<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', 'Роли');
Layout()->append('breadcrumbs', new A('Роли', ShortUrl(__dir('/'))));
