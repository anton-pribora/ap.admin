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
