<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

Layout()->appendOnce('head.css.links', ExternalUrl('@cdn/bootstrap5/bootstrap.min.css'));
Layout()->appendOnce('body.js.links', ExternalUrl('@cdn/bootstrap5/bootstrap.bundle.min.js'));

RequireLib('bootstrap-icons');
