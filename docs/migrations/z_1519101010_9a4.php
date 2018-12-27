<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

// Write you code here
//
// You can use
// Db()->query('some sql');  for quering

$defaultLogin = 'mainadmin';
$defaultPassw = '12345';

$admin = new \Site\Consultant();
$admin->info()->setLogin($defaultLogin);
$admin->info()->setFirstName('Admin');
$admin->info()->setLastName('Admin');
$admin->info()->setPost('Administrator');
$admin->setRoleId('admin');

Module('auth')->execute('set_password.php', $admin, $defaultPassw);

$admin->save();
$admin->meta()->save();