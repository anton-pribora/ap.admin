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
        'guid'       => [
            'field'   => 'guid',
            'title'   => 'Уникальный идентификатор для публичного скачивания',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'group'      => [
            'field'   => 'group',
            'title'   => 'Группа, к которой относится файл (attachment, avatar, thumbnail и т.д.)',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'path'       => [
            'field'   => 'path',
            'title'   => 'Путь на сервере',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'name'       => [
            'field'   => 'name',
            'title'   => 'Название файла при скачивании',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'parentType' => [
            'field'   => 'parent_type',
            'title'   => 'Тип родителя',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'parentId'   => [
            'field'   => 'parent_id',
            'title'   => 'Идентификатор родителя',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'mime'       => [
            'field'   => 'mime',
            'title'   => 'MIME-тип содержимого файла',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'size'       => [
            'field'   => 'size',
            'title'   => 'Размер файла',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'meta'       => [
            'field'   => 'meta',
            'title'   => 'Дополнительные данные в формате JSON',
            'encode'  => 'json_encode_array',
            'decode'  => 'json_decode_array',
            'default' => [],
        ],
        'createdAt'  => [
            'field'   => 'created_at',
            'title'   => 'Дата и время создания записи',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => function() { return date(DATE_ATOM); },
        ],
    ],
];
