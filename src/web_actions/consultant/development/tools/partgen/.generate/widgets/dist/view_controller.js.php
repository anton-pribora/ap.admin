<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = strtr(basename(__FILE__), ['.php' => '']);
$this->param('printIndent')("{$fileName} ... ");

$templateId = $this->param('widget.templateId.viewForm');
$editDialogComponent = $this->param('widget.component.editDialog');
$widgetStore = $this->param('widget.store');
$widgetFullPath = $this->param('widget.fullPath');
$viewForm = $this->param('widget.component.viewForm');
$textConfirmRemove = $this->param('text.confirmRemove');

$data = <<<'JS'
app.component('{$viewForm}', {
  template: '#{$templateId}',
  computed: {
    data() {
      return this.$store.state.$widgetStore.data;
    }
  },
  methods: {
    async edit(e) {
      const data = await this.$externalMethods.call('{$editDialogComponent}()', e);

      if (data) {
        this.$store.commit('$widgetStore/save', data.item);
        this.$toast.success(`Данные были обновлены`);
      }
    },
    async remove(e) {
      if (await this.$confirm('{$textConfirmRemove}')) {
        e.deleting = true;

        if (await this.$do('{$widgetFullPath}::remove', e)) {
          location.reload();
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
})
JS;

$data = strtr($data, [
    '{$viewForm}' => $viewForm,
    '{$editDialogComponent}' => $editDialogComponent,
    '{$widgetStore}' => $widgetStore,
    '{$templateId}' => $templateId,
    '$widgetStore' => $widgetStore,
    '{$widgetFullPath}' => $widgetFullPath,
    '{$textConfirmRemove}' => $textConfirmRemove
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
