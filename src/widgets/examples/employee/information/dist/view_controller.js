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

        if (await this.$do(`${this.widget}::remove`, e)) {
          location.reload();
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
})