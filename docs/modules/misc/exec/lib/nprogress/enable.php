<?php

Layout()->append('head.js.cdn', 'nprogress');
Layout()->append('head.css.cdn', 'nprogress');
Layout()->append('head.css.code', '#nprogress .bar {background-color: lightgreen;}');

Layout()->append('body.js.begin', 'NProgress.start();');
Layout()->append('body.js.code', <<<'JS'
$(function () {
    NProgress.done();
});

$(window).on('beforeunload', function(){
    NProgress.start();
});
JS
);