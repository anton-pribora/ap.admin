<?php

use ApCode\Html\Element\A;
use ApCode\Html\Element\UnescapedText;

if (!Identity()->require('consultant')) {
    return Module('auth')->execute('login.php');
}

if (Identity()->consultant()->isDeleted()) {
    Identity()->logout();
    return Module('auth')->execute('login.php');
}

PathAlias()->set('@template', 'admin-bs3');
PathAlias()->set('@layout', 'dashboard');

Config()->set('template.layout.error', 'dashboard');

PathAlias()->append('~/', basename(__DIR__) .'/');

Layout()->prepend('head.title', 'Панель управления');
Layout()->append('breadcrumbs', new A(new UnescapedText('<i class="fa fa-home"></i> Главная'), ShortUrl(__DIR__ .'/')));

$meta = Meta(__DIR__);

$createMenu = function ($items, Data\Layout\Menu $menu = NULL) use (&$createMenu) {
      if (is_null($menu)) {
          $menu = new Data\Layout\Menu;
      }
      
      foreach ($items as $i => $item) {
          if (isset($item['match'])) {
              $active = preg_match($item['match'], Url()->shortUrl("")->getPath());
          } else {
              $active = Url()->matchPath($item['url']);
          }
          
          $menuItem = $menu->createItem([
              'text'     => $item['text'], 
              'href'     => $item['url'], 
              'active'   => $active, 
              'priority' => $i * 10,   
          ]);
          
          if (!empty($item['submenu'])) {
              $createMenu($item['submenu'], $menuItem->subMenu());
          }
      }
      
      return $menu;
};

if ($meta->has('menu')) {
    Layout()->setVar('menu', $createMenu($meta->get('menu')));
}

foreach ($meta->get('usermenu') as $menu) {
    if (is_array($menu)) {
        Layout()->append('usermenu', new A(new UnescapedText($menu['title']), $menu['url']), Url()->matchPath($menu['url']));
    } else {
        Layout()->append('usermenu', $menu);
    }
}