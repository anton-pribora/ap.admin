<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = strtr(basename(__FILE__), ['.php' => '']);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'JS'
store.registerModule('{$widgetStore}', {
  namespaced: true,
  state: () => ({
    data: {}
  }),
  mutations: {
    save(state, e) {
      state.data = e;
    }
  }
});

JS;

$data = strtr($data, [
    '{$widgetStore}' => $this->param('widget.store')
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
