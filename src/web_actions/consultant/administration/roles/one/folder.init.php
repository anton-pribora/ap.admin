<?php

/* @var $this ApCode\Executor\RuntimeInterface */

$record = Project\Role::getInstance(Request()->get('role_id'));

// Запись не найдена
if (empty($record->id())) {
    Redirect(ShortUrl(dirname(__DIR__) . '/'));
}

Url()->makeStaticParam('role_id');

$this->setParam('record', $record);

PathAlias()->append('~/', basename(__DIR__) .'/');

Layout()->setVar('title', $record->name());
Layout()->append('breadcrumbs', $record->urlAsset('link.view'));
