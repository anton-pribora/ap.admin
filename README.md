# ap.admin
Платформа для разработки личных кабинетов

## Установка

1. Клонируйте репозиторий в свою систему и перейдите в папку с репозиторием

   ```bash
   mkdir /var/www/ВАШ_ДОМЕН
   cd /var/www/ВАШ_ДОМЕН
   git clone --depth 1 https://github.com/anton-pribora/ap.admin.git .
   ```

2. Установите конфиг сайта

   Для NGINX:
   
   ```bash
   sed -e "s/ap.admin/$(basename $PWD)/g" conf/nginx.conf.example > conf/nginx.conf
   ln -s $PWD/conf/nginx.conf /etc/nginx/sites-enabled/$(basename $PWD).conf
   service nginx reload
   ```

3. Поменяйте владельца для папок, в которых будут создаваться файлы от web-сервера

   ```
   chown www-data src/uploads/ src/web_docroot/thumbnails/ src/web_docroot/asset/ src/web_docroot/cdn/ logs/
   ```

4. Установка завершена!

   Теперь можно удалить репозиторий ap.admin и инициализировать свой:
   
   ```bash
   rm -rf .git LICENSE README.md
   git init
   git add .
   git commit -m 'Начальный коммит'
   ```

Приятной работы :)

### Вход в систему

По умолчанию войти в систему под логином `test` с паролем `123`. При этом подключение к базе данных не требуется.

### Настройка базы данных и применение миграций

Создайте файл с локальными настройками `src/configs/10-local.php`:

```php
<?php

Config()->setup([
    // Настройки базы данных
    'db' => [
        'dsn'      => 'mysql:dbname=test;host=localhost;charset=utf8',
        'login'    => 'test',
        'password' => '123',
    ],

    // Настройки для модулей
    'js' => [
        // 'ENV' => 'dev',  // Vue 3 расширение для режима разработки (требует дополнительной загрузки библиотек)
    ],
]);
```
Примените миграции:

```bash
$ php src/migrations/apply.php
```

## Composer

Чтобы подключить composer к проекту, перейдите в папку `src` и выполните:

```bash
% composer init
```

## Частые вопросы

### Почему Ap.admin не похож ни на один современный движок вроде Symfony или Laravel?

Современные движки делают слишком большой упор на ООП и шаблоны программирования. Ap.admin делает упор на простоту и 
надёжность. Мы ориентируемся прежде всего на корпоративный сектор, где проекты должны работать годами без поддержки,
а разрабатывают их люди с низкой квалификацией.

### По какому принципу разделять код?

Мы рекомендуем придерживаться следующей структуры файлов:

```text
src/
├── classes      Классы проекта, специфичные только для этого проекта
├── components   Заимствованные классы, которых нет в композере
├── configs      Разнообразные настройки
├── functions    Функции-помощники
├── init         Инициализация системы (как для вэба, так и для консоли)
├── migrations   Миграции для изменения структуры базы данных
├── modules      Модули, куда удобно помещать большие куски кода, сложную бизнес-логику и т.п.
├── permissions  Права пользователей
├── templates    Шаблоны для админки, главной, писем, pdf и т.п.
├── uploads      Загруженные файлы пользователей
├── web_actions  <-- Основная рабочая папка разработчика, тут код "действий"
├── web_docroot  Публичная папка, которая открыта всем
└── widgets      Сложные формы, которые подключаются в разных частях проекта
```

Код разделять по следующему принципу:

1. Надо сделать "по-быстрому, за пару минут" - добавляем весь код в web_actions.
2. Особо никуда не торопимся - подключаем шаблоны.
3. Сложная логика или много кода - выносим в модуль, подключаем его из web_actions.
4. Сложная форма редактирования со сложной логикой на яваскрипте - создаём виджеты.

### Почему в проекте нет построителя запросов?

Для простых запросов он не нужен, для сложных тем более. В большинстве случаев он только усложняет код и мешает отладке.

### Сколько времени разрабатывался Ap.admin?

Какие-то части системы продумывались несколько лет. В целом, датой рождения проекта можно считать 2007 год. С 2016 проект
получил текущее название и структуру файлов. Всё это время проект использовался для разработки корпоративных кабинетов.

### Почему после установки надо удалять папку .git? Как получать обновления движка?

После разворачивания проекта весь код становится вашим, вы можете менять и удалять любые части системы, если считаете нужным.
Ap.admin не предполагает обновлений. Ваш проект будет работать, пока вы сами его не сломаете.

### Насколько надёжен Ap.admin?

Система безопасности построена на простом принципе разделения на уровне файловой системы. Если сделать проверку прав
пользователя в файле src/web_actions/consultant/folder.init.php, то все действия в этой и вложенных папках будут доступны
только после проверки прав.

Загружаемые файлы хранятся в недоступной для публичного доступа папке и отдаются клиентам средствами движка. Загрузить "eval"
на сайт и выполнить его не получится.

```text
src/
├── uploads    <-- Загруженные файлы доступны только из PHP
├── web_actions
│   └── consultant
│       ├── .inc              <-- Действия, которые недоступны через адресную строку
│       │   └── hidden.php
│       ├── folder.init.php   <-- Срабатывает всегда перед основным действием (включая вложенные)
│       └── index.php         <-- Действие, которое доступно только после выполнения всех *.init.php
└── web_docroot
    ├── asset       <-- Публичный доступ
    └── index.php   <-- Публичный доступ
```

Единственное, на что нужно обращать внимание, функция `Asset()` - она создаёт символичные ссылки, которые доступны всем 
пользователям.

Если учесть, что каждый клиент работает на непонятно какой версии движка, то вероятность того, что взломают всех
сразу, стремится к нулю.

Помимо этого проект разрабатывается одним сертифицированным программистом без использования сторонних PHP-компонентов.  

### Какие версии PHP поддерживаются?

Проект ориентируется на ту версию PHP, которая поставляется в последней стабильной версии Debian. На сегодняшний день
это PHP 7.4. Однако, проект работает и на 7.3, и на 8.0, и даже на 8.1.
