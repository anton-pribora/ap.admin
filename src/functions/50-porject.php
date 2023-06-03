<?php

function HistoryAdd($section, $text, $recordId = null, $profileId = null, $companyId = null, $meta = null)
{
    Module('project')->execute('history/add.php', [
        'section'   => $section,
        'text'      => $text,
        'recordId'  => $recordId,
        'profileId' => $profileId,
        'companyId' => $companyId,
        'meta'      => $meta
    ]);
}

/**
 * Преобразует путь к файлу с правами в путь разрешения
 *
 * @param $fullpath
 * @return string
 */
function __path_to_permission($fullpath)
{
    return trim(strtr($fullpath, [
       ExpandPath('@permissions/') => '',  // обрезаем путь папки с правами
       '.php'                           => '',  // убираем расширение
       '/'                              => '.'  // заменяем слэши на точки
    ]), '.');
}

function text_udiff($oldText, $newText) {
    $cmd = sprintf('diff -u2 <(echo %s) <(echo %s) | tail -n +3', escapeshellarg($oldText), escapeshellarg($newText));
    return shell_exec('bash -c ' . escapeshellarg($cmd));
}

function contactsToList($contacts) {
    $result = [];

    foreach ((array) $contacts as $row) {
        $extra = [];
        if ($row['primary'] ?? null) {
            $extra[] = 'основной контакт';
        }

        $type    = trim($row['type'] ?? '');
        $comment = trim($row['comment'] ?? '');
        $value   = trim($row['value'] ?? '');

        if ($comment) {
            $extra[] = $comment;
        }

        $extra = join(', ', $extra);

        if ($extra) {
            $extra = '- ' . $extra;
        }

        $result[] = trim(":{$type}: {$value} {$extra}");
    }

    return join(PHP_EOL, $result);
}
