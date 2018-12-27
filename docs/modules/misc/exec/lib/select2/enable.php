<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

RequireLib('bootstrap3');

Layout()->appendOnce('head.css.cdn', 'select2');
Layout()->appendOnce('head.css.cdn', 'select2-bootstrap-theme');
Layout()->appendOnce('body.js.cdn' , 'select2');

Layout()->appendOnce('body.js.code', <<<'JS'
$.fn.select2.defaults.set("theme", "bootstrap");
$.fn.select2.defaults.set("language", "en");
$.fn.select2.defaults.set("width", "100%");
JS
);
