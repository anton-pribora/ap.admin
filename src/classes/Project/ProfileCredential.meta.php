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
    'db.table'   => 'profile_credential',
    'db.idfield' => 'id',
    'db.map'     => [
        'id'               => [
            'field'   => 'id',
            'title'   => 'Идентификатор записи',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'profileId' => [
            'field'   => 'profile_id',
            'title'   => 'Привязка к профайлу сотрудника',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '0',
        ],
        'login'            => [
            'field'   => 'login',
            'title'   => 'Логин',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'password'         => [
            'field'   => 'password',
            'title'   => 'Пароль',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '',
        ],
        'createdAt'        => [
            'field'   => 'created_at',
            'title'   => 'Время создания',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => function() { return date(DATE_ATOM); },
        ],
        'lastLoginTime'    => [
            'field'   => 'last_login_time',
            'title'   => 'Время последнего входа в систему',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => NULL,
        ],
        'del'              => [
            'field'   => 'del',
            'title'   => 'Флаг "удалён"',
            'encode'  => NULL,
            'decode'  => NULL,
            'default' => '0',
        ],
    ],
];
