app.component('profile-information-view-form', {
  template: '#profileInformationViewForm',
  data: () => ({
    store: 'profileInformation',
    widget: 'profile.information'
  }),
  computed: {
    data() {
      return this.$store.state[this.store].data;
    }
  },
  methods: {
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

        if (await this.$do(`${this.widget}::remove`, e)) {
          location.reload();
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
});
