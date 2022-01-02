# ap.admin
Платформа для разработки личных кабинетов

## Установка

1. Клонируйте репозиторий в свою систему и перейдите в папку с репозиторием

```bash
cd /var/www
git clone git@github.com:anton-pribora/ap.admin.git test.local
cd test.local
```

2. Установите конфиг сайта

Для NGINX:

```bash
sed -e 's/admin.pribora.info/test.local/g' conf/nginx.conf.example > conf/nginx.conf
ln -s $PWD/conf/nginx.conf /etc/nginx/sites-enabled/test.local.conf
service nginx reload
```

3. Поменяйте владельца для папок, в которых будут создаваться файлы от web-сервера

```
chown www-data docs/uploads/ docs/web_docroot/thumbnails/ docs/web_docroot/asset/ docs/web_docroot/cdn/cache/ logs/ logs/site_common.log
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

## Composer

Чтобы подключить composer к проекту, перейдите в папку `docs` и выполните:

```bash
% composer init
```

