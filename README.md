# ap.admin
Платформа для разработки личных кабинетов

## Установка

1. Клонируйте репозиторий в свою систему и перейдите в папку с репозиторием

```bash
cd /var/www
git clone git@github.com:anton-pribora/ap.admin.git test.local
cd test.local
```

2. Создайте базу данных и пользователя

```bash
mysql -e "CREATE DATABASE test_db;"
mysql -e "GRANT ALL PRIVILEGES ON `test_db`.* TO 'test_user'@'localhost' IDENTIFIED BY '1233456';"
```

3. Создайте локальный конфиг `configs/20-local.php` и укажите в нём настройки сайта

```php
<?php

Config()->setup([
    // Настройки базы данных
    'db' => [
        'dsn'      => 'mysql:dbname=test_db;host=localhost;charset=utf8',
        'login'    => 'test_user',
        'password' => '1233456',
    ],
    
    // Эти настройки нужны, чтобы создавать правильные ссылки из консольных скриптов
    'console' => [
        '_SERVER' => [
            'HTTPS'       => 'off',
            'SERVER_PORT' => '80',
            'SERVER_NAME' => 'test.local',
        ],
    ],
]);
```

4. Примените миграции

```bash
./docs/migrations/apply.php
```

5. Поменяйте владельца для папок, в которых будут создаваться файлы от web-сервера

```
chown www-data docs/uploads/ docs/web_docroot/thumbnails/ docs/web_docroot/asset/ docs/web_docroot/cdn/cache/ logs/ logs/site_common.log
```

6. Устновите конфиг сайта

Для NGINX:

```bash
sed -e 's/admin.pribora.info/test.local/g' conf/nginx.conf.example > conf/nginx.conf
ln -s $PWD/conf/nginx.conf /etc/nginx/sites-enabled/test.local.conf
service nginx reload
```

7. Установка завершена!

Теперь можно удалить репозиторий ap.admin и инициализировать свой:

```bash
rm -rf .git LICENSE README.md
git init
git add .
git commit -m 'Начальный коммит'
```

Приятной работы :)

## Composer

Чтобы подключить composer к проекту, перейдите в папку `docs` и выполните:

```bash
% composer init
```

После этого добавьте в файл `docs/init/20-autoload.php` подключение конфига composer:

```php
<?php
// Файл docs/init/20-autoload.php

// Компоненты проекта вне композера
glob_include(ROOT_DIR . '/components/*/bootstrap.php');

// Компоненты композера
glob_include(ROOT_DIR . '/vendor/autoload.php');

// Классы проекта
spl_autoload_register(function ($class) {
    $file = ROOT_DIR . '/classes/' . strtr($class, '\\', '/') . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});
```