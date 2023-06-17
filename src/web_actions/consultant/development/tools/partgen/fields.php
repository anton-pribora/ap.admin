<?php

try {
    $res = Db()->query('show full columns from ' . Db()->quoteName(Request()->get('table')));
} catch (Exception $exception) {
    ReturnJsonError('db_error', $exception->getMessage());
}

$lowerCamelCase = function ($str) {
    if (preg_match('/^[A-Z][a-z]/', $str)) {
        $str = lcfirst($str);
    }

    return preg_replace_callback('/[_-](\w)/u', function ($matches) {
        return mb_strtoupper($matches[1]);
    }, $str);
};

$normalizeId = function ($str) {
    return preg_replace('/([a-z])(ID)$/', '$1Id', $str);
};

$result = [];

foreach ($res->fetchAllRows() as $row)
{
    $field   = $row['Field'];
    $type    = $row['Type'];
    $comment = $row['Comment'];
    $default = $row['Default'];

    $prop   = $normalizeId($lowerCamelCase($field));
    $title  = trim($comment) ?: $field;
    $format = '';
    $getter = $prop;
    $setter = 'set' . ucfirst($prop);

    $view   = true;
    $edit   = true;
    $search = false;

    switch (mb_strtolower(preg_replace('/\W.+/', '', $type))) {
        case 'char':
        case 'varchar':
            $format = 'string';
            break;

        case 'text':
        case 'mediumtext':
        case 'longtext':
            $format = 'text';
            break;
    }

    if (preg_match('/^(creation|created_?at)$/ui', $prop)) {
        $format = 'createdAt';
        $edit     = false;
    } elseif ($prop === 'meta') {
        $format  = 'meta';
        $edit    = false;
        $view    = false;
        $search  = false;
        $default = trim($default, "'");
    } elseif ($prop === 'del') {
        $format  = 'del';
        $edit    = false;
        $view    = false;
        $search  = true;
        $default = trim($default, "'");
    } elseif (preg_match('/(text|blob)/ui', $type) && str_contains($row['Collation'], 'bin')) {
        $format  = 'json';
        $edit    = false;
        $view    = false;
        $search  = false;
        $default = trim($default, "'");
    }

    if (strtolower($prop) === 'id') {
        $prop   = 'id';
        $getter = 'id';
        $setter = 'setId';
        $format = '';

        $view   = false;
        $edit   = false;
        $search = true;
    }

    if (preg_match('/(name|title|description)/', $prop) && in_array($format, ['text', 'string'])) {
        $search = true;
    }

    $result[] = [
        'field'   => $field,
        'prop'    => $prop,
        'getter'  => $getter,
        'setter'  => $setter,
        'title'   => $title,
        'view'    => $view,
        'edit'    => $edit,
        'search'  => $search,
        'format'  => $format,
        'default' => json_encode_array($default),
    ];
}

ReturnJson($result);
