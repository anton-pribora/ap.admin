<?php
/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

RequireLib('bootstrap3');
RequireLib('moment');

Layout()->appendOnce('head.css.cdn', 'bootstrap-datepicker');
Layout()->appendOnce('body.js.cdn', 'bootstrap-datepicker');
