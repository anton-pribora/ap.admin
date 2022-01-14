app.use({
  install(app) {
    app.config.globalProperties.$clone = e => JSON.parse(JSON.stringify(e));
  }
});
