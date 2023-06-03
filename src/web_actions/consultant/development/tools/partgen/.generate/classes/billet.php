<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Codebuilder\PhpFile;
use ApCode\Codebuilder\PhpInterface;
use ApCode\Codebuilder\PhpNamespace;
use ApCode\Codebuilder\PhpValueArray;
use ApCode\Codebuilder\PhpValueRawCode;

$cwd         = $this->param('cwd');
$name        = $this->param('part.name');
$table       = $this->param('part.table');
$path        = $this->param('part.path');
$billetClass = $this->param('part.billet');
$recordIdKey = $this->param('part.recordIdKey');
$fields      = $this->param('fields');

$qname = $billetClass;                          // Полное имя класса, включая пространство имён
$fname = strtr($qname, '\\', '/');              // Полное имя файла, в котором будет класс, не включая расширения
$cname = basename($fname);                      // Имя класса без пространства имён
$nname = strtr(dirname($fname), '/', '\\');     // Пространство имён

$fullBilletPath = $cwd . '/' . $fname . '.php';
$fullMetaPath   = $cwd . '/' . $fname . '.meta.php';

$billetNamspace = new PhpNamespace('ApCode\\Billet');
$billetAbstract = $billetNamspace->createClass('AbstractBillet');

$urlAssetInterface = new PhpInterface('UrlAssetInterface', new PhpNamespace('Interfaces\\Data'));

$namespace = new PhpNamespace($nname);

$primaryClass = $namespace->createClass($cname);
$primaryClass->addExtension($billetAbstract);
$primaryClass->addImplementation($urlAssetInterface);
$primaryClass->addTrait('History');
$primaryClass->style()->setOption('function.phpdoc', false);

$primaryClass->addDescription($name);
$fieldsMap     = [];
$firstColumn   = null;

$classFunctions = [];

$classExists = file_exists($fullBilletPath);
$existingMap = file_exists($fullMetaPath) ? (include($fullMetaPath))['db.map'] : [];

foreach ($fields as $dbField => $field) {
    if ( is_null($firstColumn) ) {
        $firstColumn  = $dbField;
        $propertyName = 'id';
    }
    else {
        $propertyName = $field['prop'];
    }

    if (isset($existingMap[$propertyName])) {
        continue;
    }

    $encoder = null;
    $decoder = null;
    $default = isset($field['default']) ? json_decode($field['default'], true) : null;

    switch ($field['format']) {
        case 'createdAt':
            $default = new PhpValueRawCode('function() { return date(DATE_ATOM); }');
            break;

        case 'meta':
        case 'json':
            $encoder = 'json_encode_array';
            $decoder = 'json_decode_array';
            $default = new PhpValueRawCode('[]');
            break;
    }

    $fieldsMap[ $propertyName ] = [
        'field'   => $dbField,
        'title'   => $field['title'],
        'encode'  => $encoder,
        'decode'  => $decoder,
        'default' => $default,
    ];

    if ($field['format']) {
        $primaryClass->addTrait('Meta');
    }

    // Getter
    $primaryClass->createFunction($field['getter'])
        ->addBodyLine('return $this->data[\''. $propertyName .'\'] ?? null;');

    $classFunctions[$field['getter']] = true;

    // Setter
    $primaryClass->createFunction($field['setter'])
        ->addBodyLine('$this->data[\''. $propertyName .'\'] = $value;')
        ->addBodyLine('return $this;')
        ->createArgument('value');
}

$forceRewrite = false;

if ($classExists) {
    // Для существующего класса вносим изменения, отталкиваясь от существующих файлов
    $classFile = file_get_contents($fullBilletPath);
    $metaFile  = file_get_contents($fullMetaPath);

    if (!empty($fieldsMap)) {
        $forceRewrite = true;

        // Добавляем для класса недостающие геттеры и сеттеры
        $text = [];

        foreach ($primaryClass->getFunctions() as $function) {
            $text[] = $primaryClass->style()->render($function);
        }

        // Заменяем строго последнюю закрывающую фигурную скобку на геттеры и сеттеры
        $classFile = preg_replace('~}$~', "\n" . join("\n\n", $text), rtrim($classFile)) . "\n}\n";

        // Добавляем новые свойства в мету
        $metaArray = (new PhpValueArray([
            'db.map' => $fieldsMap,
        ]))->render('    ');

        preg_match('/ {8}[\s\S]* {8}],/', $metaArray, $matches);

        $metaFile = preg_replace('/^\s+],[\s.]*];/m', $matches[0] . "\n\$0", $metaFile);
    }
} else {
    // Класс ещё не создан, создаём его

    // Класс всегда должен содержать метод name()
    if (!isset($classFunctions['name'])) {
        $primaryClass->createFunction('name')->addBodyLine('return self::class . \'#\' . $this->id();');
    }

    $urlAssetFunction = $primaryClass->createFunction('urlAsset');
    $urlAssetFunction->createArgument('key');
    $urlAssetFunction->createArgument('params')->setDefaultValueNull();
    $urlAssetFunction->addBodyLine(<<<PHP
\$param = function(\$name, \$default = null) use(&\$params) { return isset(\$params[\$name]) ? \$params[\$name] : \$default; };
        \$scope = \$param('scope', Config()->get('urlAsset.scope', 'admin'));

        switch ("\$scope:\$key") {
            case 'admin:url.view' : return ShortUrl('{$path}/one/', ['{$recordIdKey}' => \$this->id()]);

            case 'admin:link.view': return (new \ApCode\Html\Element\A(\$param('text', \$this->name() ?: '(без названия)'), \$this->urlAsset('url.view', \$params), \$param('title')));
        }

        trigger_error(sprintf('Unknown url asset %s in scope %s', \$key, \$scope), E_USER_WARNING);
        return null;
PHP
    );

    $metaArray = new PhpValueArray([
        'db.table'   => $table,
        'db.idfield' => $firstColumn,
        'db.map'     => $fieldsMap,
    ]);

    $metaFile = new PhpFile();
    $metaFile->addContents(<<<EOL
// 'db.table'   - Обязательное поле, название таблицы
// 'db.idfield' - Обязательное поле, первичный ключ таблицы
// 'db.map'     - Карта сопоставления свойств объекта полям таблицы
//   'field'    - Обязательное поле, соответствует столбцу в базе данных
//   'title'    - Необязательное поле, содержит "человеческое" название поля
//   'encode'   - Необязательное поле, функция для кодирования значения поля при сохранении в базу
//   'decode'   - Необязательное поле, функция для декодирования значения поля при загрузке из базы
//   'default'  - Значение по-умолчанию, если установлена функция, то будет использован результат её работы
EOL
);
    $metaFile->addContents("\nreturn ". $metaArray->render('    ') .';');

    $classFile = new PhpFile();
    $classFile->addContentLine('');
    $classFile->addContents($primaryClass);

    $classFile .= PHP_EOL;
    $metaFile  .= PHP_EOL;
}

$this->param('printIndent')(basename($fullBilletPath) . ' ... ');
if ($this->param('makeFile')($fullBilletPath, $classFile, $forceRewrite)) {
    $this->param('printOk')();
}

$this->param('printIndent')(basename($fullMetaPath) . ' ... ');
if ($this->param('makeFile')($fullMetaPath, $metaFile, $forceRewrite)) {
    $this->param('printOk')();
};

