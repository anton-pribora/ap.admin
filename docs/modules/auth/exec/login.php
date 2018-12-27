<?php

/* @var $this ApCode\Executor\RuntimeInterface */

$login    = trim(Request()->get('login'));
$password = Request()->get('password');

if ($login && $password) {
    if ($this->execute('authenticate.php', $login, $password)) {
        Redirect(FullUrl(Request()->uri(), ['forcelogin' => null]));
    } else {
        Layout()->append('body.alerts', '<b>Error</b>: Wrong login or password', 'danger');
    }
}

if (Request()->has('widget_action')) {
    ReturnJsonError('You have to login. Refresh the page.', 'authorization_require');
}

Layout()->remove('head.title');
Layout()->append('head.title', 'Login please');

Layout()->setVar('login'   , $login);
Layout()->setVar('password', $password);

PathAlias()->set('@template', Config()->get('template.login.template'));
PathAlias()->set('@layout', Config()->get('template.login.layout'));

Halt()->action(true);