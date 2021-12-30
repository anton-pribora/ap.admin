app.use({
  install(app) {
    app.config.globalProperties.$do = function (action, data) {
      console.log(action, data);
      return new Promise(resolve => setTimeout(() => resolve(data), 3000));
    };
  }
});

