// Plugin to provide $externalMethods for components
const externalMethods = new function () {
  const methods = {};

  this.set = function (method, func) {
    methods[method] = func;
  };

  this.call = function (method, ...args) {
    return methods[method](...args);
  };

  this.install = function (app) {
    app.config.globalProperties.$externalMethods = {
      set: this.set,
      call: this.call,
    };
  };
};

app.use(externalMethods);
