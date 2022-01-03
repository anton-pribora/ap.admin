<?php

echo 'Пункт меню ... ';

if (!Request()->get('part.menu')) {
    echo "пропущен (не стоит галочка)\n";
    return;
}

$name = Request()->get('part.name', '(Без названия)');
$path = Request()->get('part.path', '@consultant/noname');

$data = <<<PHP
'menu' => [
        ['text' => '$name', 'url' => ShortUrl('$path/'), 'submenu' => [
            ['text' => Icon('search') . 'Все', 'url' => ShortUrl('$path/all/')],
        ]],
PHP;

$metaFile = ExpandPath('@consultant/folder.meta.php');
$meta = file_get_contents($metaFile);

if (strpos($meta, $path) > -1) {
    echo "пропущен (уже добавлен)\n";
    return;
}

$newMeta = str_replace("'menu' => [", $data, $meta, $count);

if ($count <= 0) {
    echo "ошибка (не удалось найти место для добавления нового пункта)\n";
    return;
}

if (!is_writable($metaFile)) {
    echo "ошибка (файл $metaFile не доступен для записи)\n";
    return;
}

file_put_contents($metaFile, $newMeta);

echo "добавлен ($name)";
