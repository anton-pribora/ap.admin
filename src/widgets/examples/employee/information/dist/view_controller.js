app.component('examples-employee-information-view-form', {
  template: '#examplesEmployeeInformationViewForm',
  data: () => ({
    store: 'examplesEmployeeInformation',
    widget: 'examples.employee.information'
  }),
  computed: {
    data() {
      return this.$store.state[this.store].data;
    }
  },
  methods: {
    async edit(e) {
      const result = await this.$externalMethods.call('examples-employee-information-edit-dialog()', e);

      if (result) {
        this.$store.commit(`${this.store}/save`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    },
    async remove(e) {
      if (await this.$confirm('Вы действительно хотите удалить этого сотрудника?')) {
        e.deleting = true;

        if (await this.$delay(this.$do(`${this.widget}::remove`, e))) {
          location.reload();
        } else {
          e.deleting = undefined;
        }
      }
    },
    viewAvatar(avatar) {
      this.$info('thumbnail', {id: avatar.id});
    },
    uploadAvatar(e) {
      this.$pickAndUploadFiles({
        multiple: false,
        accept: 'image/*',
        action: `${this.widget}::uploadAvatar`,
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
    async removeAvatar(e) {
      if (await this.$confirm('Вы действительно хотите удалить фото?')) {
        e.avatarDeleting = true;

        const result = await this.$delay(this.$do('examples.employee.information::removeAvatar', e));

        if (result) {
          this.$store.commit('examplesEmployeeInformation/save', result.data);
          this.$toast.success('Фото было удалено');
        } else {
          this.$toast.warning('Не удалось удалить фото');
        }

        e.avatarDeleting = undefined;
      }
    }
  }
});
