app.component('role-information-view-form', {
  template: '#roleInformationViewForm',
  data: () => ({
    store: 'roleInformation',
    widget: 'role.information'
  }),
  computed: {
    data() {
      return this.$store.state[this.store].data;
    }
  },
  methods: {
    async edit(e) {
      const result = await this.$externalMethods.call('role-information-edit-dialog()', e);

      if (result) {
        this.$store.commit(`${this.store}/save`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    },
    async remove(e) {
      if (await this.$confirm('Вы действительно хотите удалить эту запись?')) {
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
