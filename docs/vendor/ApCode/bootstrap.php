<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

spl_autoload_register(function($class) {
    if (substr_compare($class, 'ApCode\\', 0, 7) === 0) {
        include __DIR__ .'/classes/'. strtr($class, ['\\' => '/', 'ApCode\\' => '']) .'.php';
    }
});
