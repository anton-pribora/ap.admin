store.registerModule('profileInformation', {
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
