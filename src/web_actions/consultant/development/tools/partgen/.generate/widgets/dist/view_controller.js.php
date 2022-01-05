<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = strtr(basename(__FILE__), ['.php' => '']);
$this->param('printIndent')("{$fileName} ... ");

$templateId = $this->param('widget.templateId.viewForm');
$editDialogComponent = $this->param('widget.component.editDialog');
$widgetStore = $this->param('widget.store');
$viewForm = $this->param('widget.component.viewForm');

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
      const user = await this.$externalMethods.call('{$editDialogComponent}()', e);

      if (user) {
        this.$store.commit('planktonUsers/save', user);
        this.$toast.success(`Пользователь ${e.name} был ${e.id ? 'обновлён' : 'добавлен'}`);
      }
    },
    async remove(e) {
      if (await this.$confirm('jhjhbjhbjhb')) {
        e.deleting = true;

        if (await this.$do('jbjjjkn/remove', e)) {
          this.$store.commit('planktonUsers/remove', e);
          this.$toast.success(`Пользователь ${e.name} был удалён`);
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
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
