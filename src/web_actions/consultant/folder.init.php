<?php

use ApCode\Html\Element\A;
use ApCode\Html\Element\UnescapedText;

if (!Identity()->require('consultant')) {
    if (Request()->isAcceptJson()) {
        ReturnJsonError('Требуется аутентификация', 'invalid_auth');
    }

    return Module('auth')->execute('login.php');
}

//if (Identity()->consultant()->isDeleted()) {
//    Identity()->logout();
//    return Module('auth')->execute('login.php');
//}

PathAlias()->set('@template', 'admin-bs5');
PathAlias()->set('@layout', 'dashboard');

Config()->set('template.layout.error', 'dashboard');

PathAlias()->append('~/', basename(__DIR__) . '/');

Layout()->append('breadcrumbs', new A(new UnescapedText('<i class="bi bi-house-door me-1"></i>Главная'), ShortUrl(__DIR__ .'/')));

$meta = Meta(__DIR__);

$createMenu = null;
$createMenu = function ($items, Data\Layout\Menu $menu = NULL) use (&$createMenu) {
      if (is_null($menu)) {
          $menu = new Data\Layout\Menu;
      }

      foreach ($items as $i => $item) {
          if ($item === false) {
              $menu->createItem([
                  'isSeparator' => true,
                  'priority'    => $i * 10,
              ]);

              continue;
          }

          if (isset($item['match'])) {
              $active = preg_match($item['match'], Url()->shortUrl("")->getPath());
          } elseif (isset($item['active'])) {
              $active = $item['active'];
          } else {
              $active = Url()->matchPath($item['url']);
          }

          $menuItem = $menu->createItem([
              'text'     => $item['text'],
              'href'     => $item['url'],
              'active'   => $active,
              'priority' => $i * 10,
              'visible'  => $item['visible'] ?? true,
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

if ($meta->has('usermenu')) {
    Layout()->setVar('usermenu', $createMenu($meta->get('usermenu')));
}

if ($meta->has('additionalmenu')) {
    Layout()->setVar('additionalmenu', $createMenu($meta->get('additionalmenu')));
}
