<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

RequireLib('angularjs');

Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/readmore.js')));