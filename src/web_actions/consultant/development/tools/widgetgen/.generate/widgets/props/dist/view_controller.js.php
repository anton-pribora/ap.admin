<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = strtr(basename(__FILE__), ['.php' => '']);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'JS'
app.component('{$viewForm}', {
  template: '#{$templateId}',
  data: () => ({
    store: '{$widgetStore}',
    widget: '{$widgetFullPath}'
  }),
  computed: {
    data() {
      return this.$store.state[this.store].data;
    }
  },
  methods: {
    async edit(e) {
      const result = await this.$externalMethods.call('{$editDialogComponent}()', e);

      if (result) {
        this.$store.commit(`${this.store}/save`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    }
  }
});

JS;

$data = strtr($data, [
    '{$viewForm}'            => $this->param('widget.component.viewForm'),
    '{$editDialogComponent}' => $this->param('widget.component.editDialog'),
    '{$widgetStore}'         => $this->param('widget.store'),
    '{$templateId}'          => $this->param('widget.templateId.viewForm'),
    '{$widgetFullPath}'      => $this->param('widget.fullPath'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
