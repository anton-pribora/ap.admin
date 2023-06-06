<?php
// 'db.table'   - Обязательное поле, название таблицы
// 'db.idfield' - Обязательное поле, первичный ключ таблицы
// 'db.map'     - Карта сопоставления свойств объекта полям таблицы
//   'field'    - Обязательное поле, соответствует столбцу в базе данных
//   'title'    - Необязательное поле, содержит "человеческое" название поля
//   'encode'   - Необязательное поле, функция для кодирования значения поля при сохранении в базу
//   'decode'   - Необязательное поле, функция для декодирования значения поля при загрузке из базы
//   'default'  - Значение по-умолчанию, если установлена функция, то будет использован результат её работы
return [
    'db.table'   => 'role',
    'db.idfield' => 'id',
    'db.map'     => [
        'id'          => [
            'field'   => 'id',
            'title'   => 'Идентификатор записи',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'tag'         => [
            'field'   => 'tag',
            'title'   => 'Коротая метка',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'name'        => [
            'field'   => 'name',
            'title'   => 'Название',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'comment'     => [
            'field'   => 'comment',
            'title'   => 'Описание',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'permissions' => [
            'field'   => 'permissions',
            'title'   => 'Права роли',
            'encode'  => 'json_encode_array',
            'decode'  => 'json_decode_array',
            'default' => [],
        ],
        'meta'        => [
            'field'   => 'meta',
            'title'   => 'Дополнительные данные',
            'encode'  => 'json_encode_array',
            'decode'  => 'json_decode_array',
            'default' => [],
        ],
        'del'         => [
            'field'   => 'del',
            'title'   => 'Флаг "удалён"',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '0',
        ],
    ],
];
