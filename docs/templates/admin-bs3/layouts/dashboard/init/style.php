<?php

RequireLib('nprogress');

$public = Asset('@layout/public/');

Layout()->append('head.css.links', $public . 'custom.css');

Layout()->prepend('head.css.cdn', 'sb-admin-2');
Layout()->append('head.js.cdn' , 'sb-admin-2');