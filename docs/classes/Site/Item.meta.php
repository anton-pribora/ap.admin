<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

// 'db.table'   - Обязательное поле, назание таблицы
// 'db.idfield' - Обязательное поле, первичный ключ таблицы
// 'db.map'     - Карта сопоставления свойств объекта полям таблицы
//   'field'    - Обязательное поле, соответсвует столбцу в базе данных
//   'title'    - Необязательное поле, содержит "человеческое" название поля
//   'encode'   - Необязательное поле, функция для кодирования значения поля при сохранении в базу
//   'decode'   - Необязательное поле, функция для декодирования значения поля при загрузке из базы 
return [
    'db.table'   => 'site_item',
    'db.idfield' => 'id',
    'db.map'     => [
        'id'           => [
            'field'  => 'id',
            'title'  => 'Идентификатор записи',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'date'         => [
            'field'  => 'date',
            'title'  => 'Дата создания записи',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'type'         => [
            'field'  => 'type',
            'title'  => 'Тип записи',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'parentItemId' => [
            'field'  => 'parent_item_id',
            'title'  => 'Привязка к родителю',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'del'          => [
            'field'  => 'del',
            'title'  => NULL,
            'encode' => NULL,
            'decode' => NULL,
        ],
    ],
];