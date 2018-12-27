<?php

use Site\Consultant;
use Site\LoginRepository;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */
/* @var $password string */

$login    = $this->argument(0);
$password = $this->argument(1);
$auth     = false;

if ($login && $password) {
    $identity = Identity();
    
    $row = LoginRepository::findOne(['login' => $login]);
    
    if ($row) {
        switch ($row['type']) {
            case 'consultant':
                $consultant = Consultant::getInstance($row['id']);
                $hash = $consultant->info()->password();
                
                if (password_verify($password, $hash)) {
                    $identity->setEntry($consultant->type(), $consultant->id(), $consultant->name());
                    $auth = true;
                    
                    if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $consultant->info()->setPassword($hash);
                        $consultant->meta()->save();
                    }
                }
                
                break;
        }
    }
    
    if ($auth) {
        Session()->start();
        $session = Auth()->activeSession();
        $session->setIdentity($identity);
    }
}

return $auth;