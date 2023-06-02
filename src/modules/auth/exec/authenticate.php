<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $password string */

$login    = $this->argument(0);
$password = $this->argument(1);
$auth     = false;

if ($login && $password) {
    $identity = Identity();

    // Логин по креденшилам
    foreach (\Project\ProfileCredentialRepository::findMany(['login' => $login]) as $credential) {
        if ($credential->verifyPassword($password)) {
            $profile = $credential->profile();

            if ($profile->id() && !$profile->del()) {
                $credential->setLastLoginTime(date('Y-m-d H:i:s'));
                $credential->save();

                Identity()->setEntry($profile->type(), $profile->id(), $profile->name());
                $auth = true;
                break;
            }
        }
    }

    if ($auth) {
        Session()->start();
        Session()->setIdentity($identity);
    }
}

return $auth;
