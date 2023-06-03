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
    'db.table'   => 'file',
    'db.idfield' => 'id',
    'db.map'     => [
        'id'         => [
            'field'   => 'id',
            'title'   => 'Идентификатор записи',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'parentType' => [
            'field'   => 'parent_type',
            'title'   => 'Тип родителя',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'parentId'   => [
            'field'   => 'parent_id',
            'title'   => 'Идентификатор родителя',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '0',
        ],
        'public'     => [
            'field'   => 'public',
            'title'   => 'Является ли файл публичным',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => false,
        ],
        'guid'       => [
            'field'   => 'guid',
            'title'   => 'Уникальный идентификатор файла',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'mime'       => [
            'field'   => 'mime',
            'title'   => 'Тип содержимого файла',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'name'       => [
            'field'   => 'name',
            'title'   => 'Оригинальное название файла',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'path'       => [
            'field'   => 'path',
            'title'   => 'Путь к файлу',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'size'       => [
            'field'   => 'size',
            'title'   => 'Размер файла в байтах',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => 0,
        ],
        'meta'       => [
            'field'   => 'meta',
            'title'   => 'Дополнительные данные',
            'encode'  => 'json_encode_array',
            'decode'  => 'json_decode_array',
            'default' => [],
        ],
        'createdAt'  => [
            'field'   => 'created_at',
            'title'   => 'Дата и время создания файла',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => function() { return date(DATE_ATOM); },
        ],
    ],
];
