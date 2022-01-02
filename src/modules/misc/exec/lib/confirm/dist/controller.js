const confirmDialog = Vue.createApp({
  data() {
    return {
      title: 'Подтвердите действие',
      message: 'Вы действительно хотите этого?',
    }
  },
  methods: {
    show(message, title) {
      if (message) {
        this.message = message;
      }

      if (title) {
        this.title = title;
      }

      this.result = null;

      return new Promise((resolve) => {
        this.resolve = resolve;
        this.modal.show();
      })
    },

    confirm() {
      this.result = true;
      this.modal.hide();
    },

    cancel() {
      this.result = false;
      this.modal.hide();
    }
  },
  mounted() {
    this.modal = new bootstrap.Modal(this.$refs.modal);

    this.$refs.modal.addEventListener('hide.bs.modal', e => {
      if (this.resolve) {
        this.resolve(this.result);
        this.resolve = undefined;
      }
    });

    this.$externalMethods.set('confirm', this.show);
  }
});

confirmDialog.use(externalMethods);
confirmDialog.mount('#confirmDialog');

app.use({
  install: app => {
    app.config.globalProperties.$confirm = (message, title) => externalMethods.call('confirm', message, title);
  }
});
