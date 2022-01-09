app.component('examples-employee-information-view-form', {
  template: '#examplesEmployeeInformationViewForm',
  computed: {
    data() {
      return this.$store.state.examplesEmployeeInformation.data;
    }
  },
  methods: {
    async edit(e) {
      const data = await this.$externalMethods.call('examples-employee-information-edit-dialog()', e);

      if (data) {
        this.$store.commit('examplesEmployeeInformation/save', data.item);
        this.$toast.success(`Данные были обновлены`);
      }
    },
    async remove(e) {
      if (await this.$confirm('Вы действительно хотите удалить этого сотрудника?')) {
        e.deleting = true;

        if (await this.$do('examples.employee.information::remove', e)) {
          location.reload();
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
})