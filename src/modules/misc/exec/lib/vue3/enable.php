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
JS
);

Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/externalMethods.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/ajaxLoader.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/clone.js')));

RequireLib('toast');
