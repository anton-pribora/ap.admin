store.registerModule('profileRoles', {
  namespaced: true,
  state: () => ({
    data: {}
  }),
  mutations: {
    save(state, e) {
      state.data = e;
    }
  }
});
