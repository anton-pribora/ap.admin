<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

Layout()->appendOnce('body.content.end', file_get_contents(__dir('dist/view.html')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/controller.js')));
