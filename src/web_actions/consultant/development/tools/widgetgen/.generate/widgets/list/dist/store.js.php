<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = strtr(basename(__FILE__), ['.php' => '']);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'JS'
store.registerModule('{$widgetStore}', {
  namespaced: true,
  state: () => ({
    list: []
  }),
  mutations: {
    saveList(state, newList) {
      state.list = newList;
    },
    saveItem(state, item) {
      const idx = state.list.findIndex(e => e.id === item.id);

      if (idx >= 0) {
        state.list.splice(idx, 1, item);
      } else {
        state.list.unshift(item);
      }
    },
    removeItem(state, item) {
      const idx = state.list.findIndex(e => e.id === item.id);

      if (idx >= 0) {
        state.list.splice(idx, 1);
      }
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
