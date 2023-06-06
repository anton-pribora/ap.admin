<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = strtr(basename(__FILE__), ['.php' => '']);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'JS'
app.component('{$editDialogComponent}', {
  template: '#{$editDialogTemplate}',
  data: () => ({
    widget: '{$widgetFullPath}',

    data: {},
    loading: false
  }),
  methods: {
    show(e) {
      this.data = this.$clone(e);
      this._dirty = undefined;

      return new Promise((resolve) => {
        this.resolve = resolve;
        this.modal.show();
      })
    },
    async save() {
      this.modal._config.backdrop = 'static';
      this.loading = true;

      this.result = await this.$delay(this.$do(`${this.widget}::saveItem`, {data: this.data}));

      this.loading = false;
      this.modal._config.backdrop = true;

      if (this.result) {
        this._dirty = undefined;
        this.modal.hide();
      }
    },
    onChange() {
      this._dirty = true;
    }
  },
  mounted() {
    this.modal = new bootstrap.Modal(this.$refs.modal);

    this.$refs.modal.addEventListener('hide.bs.modal', e => {
      if (this._dirty) {
        if (!confirm('Некоторые данные были изменены, вы действительно хотите закрыть форму и отменить изменения?')) {
          return e.preventDefault();
        }
      }
    })

    this.$refs.modal.addEventListener('hidden.bs.modal', e => {
      if (this.resolve) {
        this.resolve(this.result);

        this.resolve = undefined;
        this.result = undefined;
      }
    });

    this.$externalMethods.set('{$editDialogComponent}()', this.show);
  }
});

JS;

$data = strtr($data, [
    '{$editDialogComponent}' => $this->param('widget.component.editDialog'),
    '{$editDialogTemplate}'  => $this->param('widget.templateId.editDialog'),
    '{$widgetFullPath}'      => $this->param('widget.fullPath'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
