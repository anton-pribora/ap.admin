<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$billet = $this->param('part.billet');
$fields = $this->param('fields');

$setters = [];

foreach ($fields as ['edit' => $edit, 'setter' => $setter, 'prop' => $prop]) {
    if ($edit) {
        $setters[] = "\$record->{$setter}(Request()->get('$prop'));";
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {billet} */

$data = Request()->getPostVariables();

if (Request()->isPost()) {
    $record = new {billet};
    {setters}
    $record->save();

    Redirect($record->urlAsset('url.view'));
}

$params = [];

$menu = [];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
//Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/new_record_form.php'), $data, $params);

PHP;

$data = strtr($data, [
    '{billet}'  => $billet,
    '{setters}' => join("\n    ", $setters)
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
