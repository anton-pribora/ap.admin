<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = strtr(basename(__FILE__), ['.php' => '']);
$this->param('printIndent')("{$fileName} ... ");

$templateId          = $this->param('widget.templateId.viewForm');
$editDialogComponent = $this->param('widget.component.editDialog');
$widgetStore         = $this->param('widget.store');
$widgetFullPath      = $this->param('widget.fullPath');
$viewForm            = $this->param('widget.component.viewForm');
$textConfirmRemove   = $this->param('text.confirmRemove');

$data = <<<'JS'
app.component('{$viewForm}', {
  template: '#{$templateId}',
  data: () => ({
    store: '{$widgetStore}',
    widget: '{$widgetFullPath}',
    pager: {
      page : 0,
      limit : 50
    },
    loading: false
  }),
  computed: {
    list() {
      return this.$store.state[this.store].list;
    },
    pages() {
      const newPages = Math.ceil((this.list.length || 1) / this.pager.limit);
      return Array.from(Array(newPages).keys());
    },
    filtered() {
      return this.list.slice(this.pager.page * this.pager.limit, (this.pager.page + 1) * this.pager.limit);
    }
  },
  mounted() {
    this.$watch('pages', () => this.pager.page = 0);
  },
  methods: {
    async reloadList() {
      this.loading = true;
      const result = await this.$do(`${this.widget}::list`);
      this.loading = false;

      if (result) {
        this.$store.commit(`${this.store}/saveList`, result);
      }
    },
    async edit(e) {
      const result = await this.$externalMethods.call('{$editDialogComponent}()', e);

      if (result) {
        this.$store.commit(`${this.store}/updateItem`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    },
    async remove(e) {
      if (await this.$confirm(`Вы действительно хотите удалить этот элемент?`)) {
        e.deleting = true;

        if (await this.$do(`${this.widget}::removeItem`, {data: e})) {
          this.$store.commit(`${this.store}/removeItem`, e);
          this.$toast.success(`Элемент был удалён`);
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
});

JS;

$data = strtr($data, [
    '{$viewForm}'            => $viewForm,
    '{$editDialogComponent}' => $editDialogComponent,
    '{$widgetStore}'         => $widgetStore,
    '{$templateId}'          => $templateId,
    '{$widgetFullPath}'      => $widgetFullPath,
    '{$textConfirmRemove}'   => $textConfirmRemove
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
