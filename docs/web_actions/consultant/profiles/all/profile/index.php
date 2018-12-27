<?php

$profile = ConsultantProfilesEnv::$profile;

$params = [
    'consultant.edit'            => Identity()->consultant()->hasPermit('profile/edit', $profile),
    'consultant.can_change_role' => Identity()->consultant()->hasPermit('profile/change_role', $profile),
    'consultant.can_remove'      => Identity()->consultant()->hasPermit('profile/remove', $profile),
];

Module('widgets')->execute('handle.php', $profile, $params);

Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
Template()->render('~/view.php', $profile, $params);