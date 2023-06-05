app.component('profile-password-view-form', {
  template: '#profilePasswordViewForm',
  data: () => ({
    store: 'profilePassword',
    widget: 'profile.password'
  }),
  computed: {
    data() {
      return this.$store.state[this.store].data;
    }
  },
  methods: {
    async edit(e) {
      const result = await this.$externalMethods.call('profile-password-edit-dialog()', e);

      if (result) {
        this.$store.commit(`${this.store}/save`, result.data);
        this.$toast.success(`Данные были обновлены`);
      }
    },
  }
});
