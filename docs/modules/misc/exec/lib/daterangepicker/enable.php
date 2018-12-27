<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

RequireLib('moment');

Layout()->appendOnce('head.css.cdn', 'bootstrap-daterangepicker');
Layout()->appendOnce('body.js.cdn', 'bootstrap-daterangepicker');