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
    'db.table'   => 'employee',
    'db.idfield' => 'id',
    'db.map'     => [
        'id'               => [
            'field'   => 'id',
            'title'   => 'Идентификатор записи',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'name'             => [
            'field'   => 'name',
            'title'   => 'ФИО',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'post'             => [
            'field'   => 'post',
            'title'   => 'Должность',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'responsibilities' => [
            'field'   => 'responsibilities',
            'title'   => 'Обязанности',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'meta'             => [
            'field'   => 'meta',
            'title'   => 'Дополнительные данные в формате JSON',
            'encode'  => 'json_encode_array',
            'decode'  => 'json_decode_array',
            'default' => [],
        ],
    ],
];
