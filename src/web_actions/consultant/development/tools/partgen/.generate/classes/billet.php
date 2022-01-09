<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Codebuilder\PhpFile;
use ApCode\Codebuilder\PhpInterface;
use ApCode\Codebuilder\PhpNamespace;
use ApCode\Codebuilder\PhpValueArray;

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

$billetNamspace = new PhpNamespace('ApCode\\Billet');
$billetAbstract = $billetNamspace->createClass('AbstractBillet');

$urlAssetInterface = new PhpInterface('UrlAssetInterface', new PhpNamespace('Interfaces\\Data'));

$namespace = new PhpNamespace($nname);

$primaryClass = $namespace->createClass($cname);
$primaryClass->addExtension($billetAbstract);
$primaryClass->addImplementation($urlAssetInterface);
$primaryClass->style()->setOption('function.phpdoc', false);

$primaryClass->addDescription($name);
$fieldsMap     = [];
$firstColumn   = null;

$classFunctions = [];

foreach ($fields as $dbField => $field) {
    if ( is_null($firstColumn) ) {
        $firstColumn  = $dbField;
        $propertyName = 'id';
    }
    else {
        $propertyName = $field['prop'];
    }

    $encoder = null;
    $decoder = null;

    switch ($field['format']) {
        case 'json':
            $encoder = 'json_encode_array';
            $decoder = 'json_decode_array';
            break;
    }

    $fieldsMap[ $propertyName ] = [
        'field'  => $dbField,
        'title'  => $field['title'],
        'encode' => $encoder,
        'decode' => $decoder,
    ];

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

        throw new \Exception(sprintf('Unknown url asset %s in scope %s', \$key, \$scope));
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
EOL
);
$metaFile->addContents("\nreturn ". $metaArray->render('    ') .';');

$classFile = new PhpFile();
$classFile->addContentLine('');
$classFile->addContents($primaryClass);

$fullBilletPath = $cwd . '/' . $fname . '.php';
$fullMetaPath   = $cwd . '/' . $fname . '.meta.php';

$this->param('printIndent')(basename($fullBilletPath) . ' ... ');
if ($this->param('makeFile')($fullBilletPath, (string) $classFile)) {
    $this->param('printOk')();
}

$this->param('printIndent')(basename($fullMetaPath) . ' ... ');
if ($this->param('makeFile')($fullMetaPath, (string) $metaFile)) {
    $this->param('printOk')();
};
