<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

Layout()->appendOnce('head.css.links', ExternalUrl('@cdn/vanillajs-datepicker/datepicker.min.css'));
Layout()->appendOnce('body.js.links', ExternalUrl('@cdn/vanillajs-datepicker/datepicker.min.js'));
Layout()->appendOnce('body.js.links', ExternalUrl('@cdn/vanillajs-datepicker/locales/ru.js'));

Layout()->appendOnce('body.js.code', <<<'JS'
app.component('date', {
  template: `<div class="input-group">
      <input
        type="text"
        ref="input"
        class="datepicker_input form-control"
        :placeholder="placeholder"
      >
      <i class="bi bi-calendar-date input-group-text"></i>
    </div>`,
  props: ['modelValue', 'placeholder'],
  emits: ['update:modelValue'],
  mounted() {
    this.picker = new Datepicker(this.$refs.input, {
      format: 'dd.mm.yyyy',
      autohide: true,
      language: 'ru'
    })

    this.$watch('modelValue', (n) => {
      this.picker.setDate(n || {clear: true});
    })

    this.$refs.input.addEventListener('changeDate', (e) => {
      this.$emit('update:modelValue', e.target.value);
    });
  },
  unmounted() {
    this.picker.destroy();
  }
});
JS
);

Layout()->appendOnce('head.css.code', <<<'CSS'
.datepicker-dropdown {
    z-index: 9999; /* arbitrary number higher than .modal's */
}
CSS
);
