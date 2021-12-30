store.registerModule('planktonOffices', {
  namespaced: true,
  state: () => ({
    list: [],
  }),
  mutations: {
    remove(state, e) {
      const idx = state.list.findIndex(item => e.id === item.id)

      if (idx >= 0) {
        state.list.splice(idx, 1)
      }
    },
    save(state, e) {
      const idx = state.list.findIndex(item => e.id === item.id)

      if (idx >= 0) {
        state.list.splice(idx, 1, e)
      } else {
        e.id = e.id || (state.list.reduce((a, b) => Math.max(a, b.id), 0) + 1)
        state.list.push(e)
      }
    },
  }
});
