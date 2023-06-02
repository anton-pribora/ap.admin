<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Codebuilder\PhpValueArray;
use ApCode\Codebuilder\PhpValueRawCode;

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$searchParams = [];

foreach ($this->param('fields') as ['prop' => $prop, 'search' => $search, 'view' => $view]) {
    if ($view && $search) {
        $searchParams[$prop] = new PhpValueRawCode("Request()->get('$prop')");
    }
}

$data = <<<'PHP'
<?php

use ApCode\Html\Element\A;
use ApCode\Html\Element\UnescapedText;

$searchParams = ['searchParams'];

$pagination = Pagination();

$items = Project\Repository::findMany($searchParams, $pagination);

$params = [];

$menu = [];

$menu = [
    Module('project')->execute('history/button.php', ['section' => {billet}::historySection(), 'viewAll' => true]),
];

if (Identity()->getPermit('{$recordKey}.add')) {
    $menu[] = new A(new UnescapedText(Icons()->get('add') . 'Добавить запись'), ShortUrl(__dir('new/')));
}

Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/search_form.php'), $searchParams);
Template()->render('@totalFound', $pagination, $params);
Template()->render('@pagination', $pagination);
Template()->render(__dir('.views/list.php') , $items, $pagination->startFrom() + 1);
Template()->render('@pagination', $pagination);

PHP;

$data = strtr($data, [
    '{billet}'           => $this->param('part.billet'),
    "['searchParams']"   => (new PhpValueArray($searchParams))->render('    '),
    'Project\Repository' => $this->param('part.repository'),
    '{$recordKey}'       => $this->param('part.key'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
