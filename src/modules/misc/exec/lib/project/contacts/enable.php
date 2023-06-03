<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

RequireLib('vue3');

Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/contactsView.js')));
Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/contactsEdit.js')));

