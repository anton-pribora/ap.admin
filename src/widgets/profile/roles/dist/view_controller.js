app.component('profile-roles-view-form', {
  template: '#profileRolesViewForm',
  data: () => ({
    store: 'profileRoles',
    widget: 'profile.roles'
  }),
  computed: {
    data() {
      return this.$store.state[this.store].data;
    }
  },
  methods: {
    async edit(e) {
      const result = await this.$externalMethods.call('profile-roles-edit-dialog()', e);

      if (result) {
        this.$store.commit(`${this.store}/save`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    }
  }
});
