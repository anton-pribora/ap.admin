const infoDialog = Vue.createApp({
  data: () => ({
    loading: false,
    title: '',
    content: '',
    modalSize: '',
  }),
  methods: {
    async show(entity, params) {
      this.loading = true;

      this.$nextTick(() => {
        this.modal.show();
      });

      const result = await this.$do('info::display', {entity, params});
      this.loading = false;

      if (result) {
        this.title = result.title;
        this.content = result.content;
        this.modalSize = result.size;
      }
    },
  },
  mounted() {
    this.modal = new bootstrap.Modal(this.$refs.modal);
    this.$externalMethods.set('info', this.show);
  }
});

infoDialog.use(externalMethods);
infoDialog.use(ajaxLoader);
infoDialog.use(toasts);

infoDialog.mount('#infoDialog');

app.use({
  install: app => {
    app.config.globalProperties.$info = (entity, params = {}) => externalMethods.call('info', entity, params);
  }
});
