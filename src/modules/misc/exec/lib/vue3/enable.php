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

app.use({
  install(app) {
    app.config.globalProperties.$do = function (action = '', data = {}) {
      return fetch('', {
        method: 'POST',
        cache: 'no-cache',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          widget_action: action,
          widget_data: data
        })
      })
        // Ошибки уровня HTTP
        .then(async response => {
          if (!response.ok) {
            const text = await response.text();
            throw new Error(text || response.statusText);
          }
          return response;
        })
        // Парсим JSON
        .then(response => response.json())
        // Ошибки уровня пользователя
        .then(data => {
          if (data.error) {
            throw new Error(`${data.error.code}: ${data.error.description}`);
          }
          return data;
        })
        .catch(error => {
          app.config.globalProperties.$toast.danger(`Ошибка: ${error.message}`);
        })
    }
  }
});
JS
);
