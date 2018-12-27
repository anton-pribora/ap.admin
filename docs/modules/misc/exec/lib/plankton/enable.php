<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

RequireLib('angularjs');
RequireLib('animate-css');
RequireLib('datepicker');
RequireLib('notify');
RequireLib('select2');

Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/jquery.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/confirm.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/info.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/notify.min.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/datepicker.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/httpInterceptor.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/httpInterceptor.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/linky.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/select2.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/uploader.js')));

Layout()->appendOnce('head.css.code', '.file-upload-in {background-color: #fcf1bf;}');

Layout()->appendOnce('content.end.html', file_get_contents(__dir('dist/info.html')));
Layout()->appendOnce('content.end.html', file_get_contents(__dir('dist/confirm.html')));