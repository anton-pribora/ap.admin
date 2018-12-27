<?php

use Site\Consultant;

$canAddNewProfile = Identity()->consultant()->hasPermit('profile/add_new');

// Валидация
$errors = [];

if (Request()->isPost() && Request()->get('createProfile')) {
    if ($canAddNewProfile) {
        $profile = new Consultant();
        $info = $profile->info();
        
        $info->setFirstName(Request()->get('firstName'));
        $info->setLastName(Request()->get('lastName'));
        
        if (empty(trim($profile->name()))) {
            $errors[] = 'Не указано имя';
        }
        
        $info->setPost(Request()->get('post'));
        $info->setRoleId(Request()->get('roleId'));
        
        $info->setEmail(Request()->get('email'));
        $info->setSkype(Request()->get('skype'));
        $info->setPhone(Request()->get('phone'));
        
        $login = Request()->get('login');
        $passw = Request()->get('password');
        
        $info->setLogin($login);
        $info->setPassword($passw);
        
        $errors = array_merge($errors, Module('auth')->execute('validate_credentials.php', [
            'login'    => $login,
            'password' => $passw,
            'parentId' => null,
        ]));
        
        Module('auth')->execute('set_password.php', $profile, $passw);
        
        if (empty($errors)) {
            $profile->save();
            $profile->meta()->save();
            
            Redirect($profile->urlAsset('url.view'));
        }
    } else {
        $errors[] = 'Вы не можете создавать новых пользователей';
    }
}

Template()->render('@extra/nav-tabs.php', Meta(dirname(__DIR__))->get('nav', []));
Template()->render('~/form.php', [
    'data' => Request()->getPostVariables() + [
    ],
    'errors'           => $errors,
    'canAddNewProfile' => $canAddNewProfile,
]);