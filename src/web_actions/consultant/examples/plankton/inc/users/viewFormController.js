app.component('users-view', {
  template: '#usersViewForm',
  computed: {
    planktons() {
      return this.$store.state.planktonUsers.list;
    },
    offices() {
      const map = {'': '-'}

      for (const office of this.$store.state.planktonOffices.list) {
        map[office.id] = `${office.name}, ${office.address}`;
      }

      return map
    },
  },
  methods: {
    async edit(e) {
      const user = await this.$externalMethods.call('plankton-user-edit()', e);

      if (user) {
        this.$store.commit('planktonUsers/save', user);
        this.$toast.success(`Пользователь ${e.name} был ${e.id ? 'обновлён' : 'добавлен'}`);
      }
    },
    async remove(e) {
      if (await this.$confirm('jhjhbjhbjhb')) {
        e.deleting = true;

        if (await this.$do('jbjjjkn/remove', e)) {
          this.$store.commit('planktonUsers/remove', e);
          this.$toast.success(`Пользователь ${e.name} был удалён`);
        } else {
          e.deleting = undefined;
        }
      }
    }
  }
})
