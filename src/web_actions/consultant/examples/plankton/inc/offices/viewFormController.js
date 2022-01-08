app.component('offices-view', {
  template: '#officesViewForm',
  computed: {
    offices() {
      return this.$store.state.planktonOffices.list;
    },
  },
  methods: {
    async edit(e) {
      const user = await this.$externalMethods.call('plankton-office-edit()', e);

      if (user) {
        this.$store.commit('planktonOffices/save', user);
        this.$toast.success(`Офис ${e.name} был ${e.id ? 'обновлён' : 'добавлен'}`);
      }
    },
    async remove(e) {
      if (await this.$confirm('Вы действительно хотите удалить этот офис?')) {
        e.deleting = true;

        if (await this.$do('office/remove', e)) {
          this.$store.commit('planktonOffices/remove', e);
          this.$toast.success(`Офис ${e.name} был удалён`);
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
})
