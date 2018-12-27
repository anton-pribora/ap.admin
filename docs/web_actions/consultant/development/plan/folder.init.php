<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', 'План разработки');
Layout()->append('breadcrumbs', new A('План разработки', ShortUrl(__dir('/'))));

Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));