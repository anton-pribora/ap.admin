app.component('profile-information-view-form', {
  template: '#profileInformationViewForm',
  data: () => ({
    store: 'profileInformation',
    widget: 'profile.information',
    photoDeleting: false
  }),
  computed: {
    data() {
      return this.$store.state[this.store].data;
    }
  },
  methods: {
    pickPhotoAndUpload() {
      this.$pickAndUploadFiles({
        multiple: false,
        accept: 'image/*',
        action: `${this.widget}::uploadPhoto`,
        after: async (success, errors) => {
          if (success && errors) {
            setTimeout(() => {
              this.$toast.warning('Не все данные были загружены');
            }, 300);
          } else if (errors) {
            setTimeout(() => {
              this.$toast.warning('Файлы не были загружены');
            }, 300);
          } else {
            this.$toast.success('Файлы успешно загружены');
          }

          const result = await this.$delay(this.$do(`${this.widget}::data`));

          if (result) {
            this.$store.commit(`${this.store}/save`, result.data);
          }
        }
      });
    },
    async removePhoto() {
      if (await this.$confirm('Вы действительно хотите удалить фото?')) {
        this.photoDeleting = true;

        const result = await this.$delay(this.$do(`${this.widget}::removePhoto`));

        if (result) {
          this.$store.commit(`${this.store}/save`, result.data);
          this.$toast.success('Фото было удалено');
        } else {
          this.$toast.warning('Не удалось удалить фото');
        }

        this.photoDeleting = false;
      }
    },
    async edit(e) {
      const result = await this.$externalMethods.call('profile-information-edit-dialog()', e);

      if (result) {
        this.$store.commit(`${this.store}/save`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    },
    async remove(e) {
      if (await this.$confirm('Вы действительно хотите удалить этого пользователя?')) {
        e.deleting = true;
        const result = await this.$delay(this.$do(`${this.widget}::remove`, e));

        if (result && result.url) {
          location.href = result.url;
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
});
