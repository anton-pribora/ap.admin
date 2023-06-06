app.component('profile-files-view-form', {
  template: '#profileFilesViewForm',
  data: () => ({
    store: 'profileFiles',
    widget: 'profile.files',
    pager: {
      page : 0,
      limit : 50
    },
    loading: false,
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
    pickAndUpload() {
      this.$pickAndUploadFiles({
        multiple: true,
        accept: '*/*',
        action: `${this.widget}::uploadFile`,
        after: this.afterUpload,
      });
    },
    upload(files) {
      this.$uploadFiles(files, {
        action: `${this.widget}::uploadFile`,
        after: this.afterUpload,
      })
    },
    async reloadList() {
      this.loading = true;
      const result = await this.$delay(this.$do(`${this.widget}::list`));
      this.loading = false;

      if (result) {
        this.$store.commit(`${this.store}/saveList`, result);
      }
    },
    afterUpload(success, errors) {
      if (success && errors) {
        setTimeout(() => {
          this.$toast.warning('Не все файлы были загружены');
        }, 300);
        this.reloadList();
      } else if (errors) {
        setTimeout(() => {
          this.$toast.warning('Файлы не были загружены');
        }, 300);
      } else {
        this.$toast.success('Файлы успешно загружены');
        this.reloadList();
      }
    },
    async edit(e) {
      const result = await this.$externalMethods.call('profile-files-edit-dialog()', e);

      if (result) {
        this.$store.commit(`${this.store}/updateItem`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    },
    async remove(e) {
      if (await this.$confirm(`Вы действительно хотите удалить «${e.name}»?`)) {
        e.deleting = true;

        if (await this.$delay(this.$do(`${this.widget}::removeFile`, {data: e}))) {
          this.$store.commit(`${this.store}/removeItem`, e);
          this.$toast.success(`Файл «${e.name}» был удалён`);
        } else {
          e.deleting = undefined;
        }
      }
    },
  }
});
