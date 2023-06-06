store.registerModule('profileFiles', {
  namespaced: true,
  state: () => ({
    list: []
  }),
  mutations: {
    saveList(state, newList) {
      state.list = newList;
    },
    updateItem(state, item) {
      const idx = state.list.findIndex(e => e.id === item.id);

      if (idx >= 0) {
        state.list.splice(idx, 1, item);
      }
    },
    removeItem(state, item) {
      const idx = state.list.findIndex(e => e.id === item.id);

      if (idx >= 0) {
        state.list.splice(idx, 1);
      }
    }
  }
});
