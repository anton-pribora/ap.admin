<?php

/* @var $this ApCode\Executor\RuntimeInterface */

Layout()->setVar('title', 'Новая запись');
Layout()->append('breadcrumbs', new \ApCode\Html\Element\A('Новая запись', ShortUrl(__dir('/'))));
