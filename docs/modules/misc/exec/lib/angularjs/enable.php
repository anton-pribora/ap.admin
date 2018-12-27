<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

$app = $this->param('app', 'app');

Layout()->setVar('ng-app', $app);

Layout()->appendOnce('head.js.cdn', 'ng');
Layout()->appendOnce('head.js.cdn', 'ng-sanitize');
Layout()->appendOnce('body.js.code', 'var app = angular.module("'. $app .'", ["ngSanitize"]);');