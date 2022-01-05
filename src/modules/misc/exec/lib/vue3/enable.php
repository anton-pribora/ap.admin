<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

$ext = Config()->get('js.ENV');

Layout()->appendOnce('body.js.links', ExternalUrl("@cdn/vue3/vue.{$ext}.js"));
Layout()->appendOnce('body.js.links', ExternalUrl("@cdn/vue3/vuex.{$ext}.js"));

Layout()->appendOnce('body.js.code', <<<'JS'
const store = Vuex.createStore();
const app = Vue.createApp({});
app.use(store);

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

JS
);
