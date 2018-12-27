<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

// RequireLib('jquery');
// RequireLib('moment');

Layout()->appendOnce('head.css.cdn', 'datatables');
Layout()->appendOnce('body.js.cdn' , 'datatables');

// Layout()->appendOnce('body.js.code', <<<'JS'
// $.fn.dataTable.moment( 'DD.MM.YYYY' );
// $.extend( true, $.fn.dataTable.defaults, {
// } );
// JS
// );