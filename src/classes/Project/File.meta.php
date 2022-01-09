<?php
// 'db.table'   - Обязательное поле, название таблицы
// 'db.idfield' - Обязательное поле, первичный ключ таблицы
// 'db.map'     - Карта сопоставления свойств объекта полям таблицы
//   'field'    - Обязательное поле, соответствует столбцу в базе данных
//   'title'    - Необязательное поле, содержит "человеческое" название поля
//   'encode'   - Необязательное поле, функция для кодирования значения поля при сохранении в базу
//   'decode'   - Необязательное поле, функция для декодирования значения поля при загрузке из базы 
return [
    'db.table'   => 'file',
    'db.idfield' => 'id',
    'db.map'     => [
        'id'         => [
            'field'  => 'id',
            'title'  => 'Идентификатор записи',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'type'       => [
            'field'  => 'type',
            'title'  => 'Тип связи файла с родителем (attachment, avtar и т.д.)',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'path'       => [
            'field'  => 'path',
            'title'  => 'Путь на сервере',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'name'       => [
            'field'  => 'name',
            'title'  => 'Название файла при скачивании',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'parentType' => [
            'field'  => 'parent_type',
            'title'  => 'Тип родителя',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'parentId'   => [
            'field'  => 'parent_id',
            'title'  => 'Идентификатор родителя',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'mime'       => [
            'field'  => 'mime',
            'title'  => 'MIME-тип содержимого файла',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'size'       => [
            'field'  => 'size',
            'title'  => 'Размер файла',
            'encode' => NULL,
            'decode' => NULL,
        ],
        'createdAt'  => [
            'field'  => 'created_at',
            'title'  => 'Дата и время создания записи',
            'encode' => NULL,
            'decode' => NULL,
        ],
    ],
];