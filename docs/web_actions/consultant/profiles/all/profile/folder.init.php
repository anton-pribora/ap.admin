<?php

use ApCode\Html\Element\A;
use Site\Consultant;

ConsultantProfilesEnv::$profile = Request()->has('profile_id') ? Consultant::getInstance(Request()->get('profile_id')) : Identity()->consultant();

$profile = ConsultantProfilesEnv::$profile;

if (empty($profile->id())) {
    Redirect(ExpandUrl('@consultant/profiles/'));
}

Url()->setStaticParam('profile_id', $profile->id());

PathAlias()->append('~/', basename(__DIR__) .'/');

Layout()->setVar('title', 'Просмотр пользователя');
Layout()->append('breadcrumbs', new A($profile->name(), ShortUrl(__DIR__ .'/')));

class ConsultantProfilesEnv
{
    /**
     * @var \Site\Consultant
     */
    public static $profile;
}