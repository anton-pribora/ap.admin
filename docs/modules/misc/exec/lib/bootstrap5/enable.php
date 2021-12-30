<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

Layout()->appendOnce('head.css.links', ShortUrl('@cdn/bootstrap5/bootstrap.min.css'));
Layout()->appendOnce('body.js.links', ShortUrl('@cdn/bootstrap5/bootstrap.min.js'));

RequireLib('bootstrap-icons');
