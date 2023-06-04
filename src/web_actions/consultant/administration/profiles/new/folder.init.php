<?php

/* @var $this ApCode\Executor\RuntimeInterface */

Layout()->setVar('title', 'Добавить пользователя');
Layout()->append('breadcrumbs', new \ApCode\Html\Element\A('Новый пользователь', ShortUrl(__dir('/'))));
