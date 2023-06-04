<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('profile.roles.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$roles = [];
$names = [];

foreach ($data['roles'] ?? [] as $tag => $item) {
    if ($item['checked'] ?? false) {
        $roles[] = $tag;

        $name = $item['name'] ?? $tag;

        if ($item['sublist'] ?? false) {
            $subName = join(', ', array_map(static fn($e) => $e['name'], array_filter($item['sublist'], static fn($e) => $e['checked'])));
            $name    = "$name ($subName)";
        }

        $names[] = $name;
    }
}

$record->addHistory('Установлены роли пользователя <b data-profile>' . $record->fullName() . '</b>: ' . ($roles ? join(', ', $names) : '(пусто)'));

$record->setRolesRaw($roles);

$record->save();

$this->include('data.php');
