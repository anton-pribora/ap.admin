store.registerModule('profilePassword', {
  namespaced: true,
  state: () => ({
    data: {
      login: '',
      last_usage: {}
    }
  }),
  mutations: {
    save(state, e) {
      state.data = e;
    }
  }
});
