<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

Layout()->appendOnce('body.js.cdn', 'notify');

Layout()->appendOnce('body.js.code', <<<'JS'
$.notifyDefaults({
    z_index: 2000,
    type: 'success',
    placement: {
        from: 'top',
        align: 'right'
    },
    animate: {
        enter: 'animated fadeInDown',
        exit: 'animated fadeOutUp'
    }
});
JS
);