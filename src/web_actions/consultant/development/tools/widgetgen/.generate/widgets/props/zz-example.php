<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */
$fullPath = $this->param('widget.fullPath');

$this->param('printIndent')("Пример использования: <?php echo Widget('{$fullPath}', \$record, \$this->paramList())?>\n");
