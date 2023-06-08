<?php

// Выполняем действия из консоли от имени консольного пользователя
$identity = Identity();

$user = \Auth\ConsoleBot::getInstance();
$identity->setEntry('console', $user->id(), $user->name());
$identity->require('console');
