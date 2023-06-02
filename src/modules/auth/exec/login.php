<?php

/* @var $this ApCode\Executor\RuntimeInterface */

// Авторизация для тех, кто использует апи
if (($_SERVER["HTTP_ACCEPT"] ?? false) && preg_match('/json/i', $_SERVER['HTTP_ACCEPT'])) {
    ReturnJsonError('Требуется авторизация', 'unauthorized');
}

$login    = trim(Request()->get('login', ''));
$password = Request()->get('password', '');

if ($login && $password) {
    if ($this->execute('authenticate.php', $login, $password)) {
        Redirect(FullUrl(Request()->uri(), ['forcelogin' => null]));
    } else {
        Layout()->append('body.alerts', 'Ошибка: Указан неверный логин или пароль', 'danger');
        sleep(2);
    }
}

if (Request()->has('widget_action')) {
    ReturnJsonError('You have to login. Refresh the page.', 'authorization_require');
}

Layout()->remove('head.title');
Layout()->append('head.title', 'Необходима аутентификация');

Layout()->setVar('login'   , $login);
Layout()->setVar('password', $password);

PathAlias()->set('@template', Config()->get('template.login.template'));
PathAlias()->set('@layout', Config()->get('template.login.layout'));

Halt()->action(true);
