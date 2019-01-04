<?php

use ApCode\Html\Element\Form;
use ApCode\Codebuilder\PhpNamespace;
use ApCode\Codebuilder\MysqlReflectionTable;
use ApCode\Html\Element\Pre;
use ApCode\Codebuilder\PhpValueArray;
use ApCode\Codebuilder\PhpFile;
use ApCode\Html\Element\Input;
use ApCode\Html\Element\UnescapedText;

Layout()->setVar('title', 'Генератор классов');
Layout()->setVar('subtitle', '(расширение для биллетов)');

Layout()->append('head.js.links', 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js');
Layout()->append('head.js.code', file_get_contents(__dir('app.js')));

$currentTable = Request()->get('t');

$form = new Form();
$form->createSubElement('label', 'Выберите таблицу ');

foreach (Url()->getStaticParams() as $name => $value) {
    $form->addSubElement((new Input($value, $name))->setType('hidden'));
}

$select = $form->createSubElement('select');
$select->setClass('form-control');
$select->setName('t');

$select->setAttribute('onchange', 'this.form.submit()');
$select->createSubElement('option', '(не указано)')->setAttribute('value', '');

foreach ( getTables() as $db => $tables) {
    foreach ($tables as $table) {
        $table = $db .'.'. $table;
        $option = $select->createSubElement('option', $table);
        $option->setAttribute('value', $table);
    
        if ( $currentTable == $table ) {
            $option->setAttribute('selected', 'selected');
        }
    }
}

?>
<form action="">
<?php
foreach (Url()->getStaticParams() as $name => $value) {
    echo (new Input($value, $name))->setType('hidden');
}
?>
	<div class="form-group">
		<label>Выберите таблицу</label>
		<?php echo $select?>
	</div>
</form>
<?php

if ( !$currentTable ) {
    return true;
}

list($currentDb, $currentTable) = explode('.', $currentTable, 2);

$qname = getFullClassName($currentTable);       // Полное имя класса, включая пространство имён
$fname = strtr($qname, '\\', '/');              // Полное имя файла, в котором будет класс, не включая расширения
$cname = basename($fname);                      // Имя класса без пространства имён
$nname = strtr(dirname($fname), '/', '\\');     // Пространство имён


$billetNamspace = new PhpNamespace('ApCode\\Billet');
$billetAbstract = $billetNamspace->createClass('AbstractBillet');

$namespace = new PhpNamespace('{{class | namespace}}');

$primaryClass = $namespace->createClass('{{class | class}}');
$primaryClass->addExtension($billetAbstract);

$tableInfo = new MysqlReflectionTable(Db(), $currentTable, $currentDb);

$primaryClass->addDescription($tableInfo->getComment());
$fieldsMap     = [];
$firstColumn   = null;

foreach ( $tableInfo->getColumns() as $column ) {
    if ( is_null($firstColumn) ) {
        $firstColumn  = $column;
        $propertyName = 'id';
    }
    else {
        $propertyName = getPropertyName($column->getName());
    }

    $fieldsMap[ $propertyName ] = [
        'field'  => $column->getName(),
        'title'  => $column->getComment() ?: null,
        'encode' => null,
        'decode' => null,
    ];
    
    // Getter
    $primaryClass->createFunction($propertyName)
        ->addBodyLine('return $this->data[\''. $propertyName .'\'] ?? null;');
    
    // Setter
    $primaryClass->createFunction('set'. ucfirst($propertyName))
        ->addBodyLine('$this->data[\''. $propertyName .'\'] = $value;')
        ->addBodyLine('return $this;')
        ->createArgument('value');
}

$idfield = $firstColumn->getName();

$metaArray = new PhpValueArray([
    'db.table'   => $tableInfo->getName(),
    'db.idfield' => $firstColumn->getName(),
    'db.map'     => $fieldsMap,
]);

$metaFile = new PhpFile();
$metaFile->addContents(<<<EOL
// 'db.table'   - Обязательное поле, назание таблицы
// 'db.idfield' - Обязательное поле, первичный ключ таблицы
// 'db.map'     - Карта сопоставления свойств объекта полям таблицы
//   'field'    - Обязательное поле, соответсвует столбцу в базе данных
//   'title'    - Необязательное поле, содержит "человеческое" название поля
//   'encode'   - Необязательное поле, функция для кодирования значения поля при сохранении в базу
//   'decode'   - Необязательное поле, функция для декодирования значения поля при загрузке из базы 
EOL
);
$metaFile->addContents("\nreturn ". $metaArray->render('    ') .';');

$classFile = new PhpFile();
$classFile->addContentLine('');
$classFile->addContents($primaryClass);

$pre1 = new Pre;
$pre2 = new Pre;
$pre3 = new Pre;

$pre1->createSubElement('UnescapedText', hl($classFile));
$pre2->createSubElement('UnescapedText', hl($metaFile));
$pre3->createSubElement('UnescapedText', hl(include (__DIR__ . '/repository.inc.php')));

?>
<style>
pre {
	background-color: white;
}
</style>
<div ng-app="app">
	<div ng-controller="main">
		<div class="form-group">
			<label>Класс</label>
			<input type="text" class="form-control" ng-model="class" ng-init="class='<?php echo addslashes($qname)?>'">
		</div>
		
		<h3>Основной класс <code>{{class | path}}.php</code></h3>
		<?php echo $pre1?>  
		
		<h3>Мета файл <code>{{class | path}}.meta.php</code></h3>
		<?php echo $pre2?> 
		
		<h3>Репозиторий <code>{{class | path}}Repository.php</code></h3>
		<?php echo $pre3?> 
	</div>
</div>


<?php 


function hl($code) {
    $filters = [
        '<code><span style="color: #000000">
<' => '<code><span style="color: #000000"><',
        '</span>
</code>' => '</span></code>'
    ];
    
    $source = preg_replace_callback('/\\{\\{[\w| ]+\\}\\}/', function ($row) use (&$filters) {
        $id = uniqid('hl');
        $filters[ $id ] = $row[0];
        return $id;
    }, $code);
    
    $hl = highlight_string($source, true);
    
    return strtr($hl, $filters);
}

function getTables() {
    $result = [];
    
    $currentDb = Db()->query('SELECT DATABASE()')->fetchValue();
    
    $result[$currentDb] = Db()->query('show tables')->fetchColumn();
//     $result['anton-pribora' ] = Db()->query('show tables from "anton-pribora"')->fetchColumn();
    
    return $result;
}

function getFullClassName($tableName) {
    $namespaces = [
        'site_' => 'Site',
        'wp_'   => 'Wordpress',
    ];
    
    $result = [];
    
    foreach ($namespaces as $prefix => $namespace) {
        if (substr_compare($tableName, $prefix, 0, strlen($prefix)) === 0) {
            $result[]  = $namespace;
            $tableName = substr($tableName, strlen($prefix));
        }
    }
    
    if (empty($result)) {
        $result[] = 'Project';
    }
    
    $result[] = join(array_map('ucfirst', explode('_', $tableName)));
    
    return join('\\', $result);
}

function getPropertyName($dbField) {
    $result = explode('_', $dbField);
    $result = array_map('ucfirst', $result);
    return lcfirst(join($result));
}