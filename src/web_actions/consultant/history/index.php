<?php

PathAlias()->set('@layout', 'blank');

Layout()->prepend('head.title', 'История изменений ' . Request()->get('section'));

Module('project')->execute('history/show.php', [
    'section'    => Request()->get('section'),
    'recordId'   => Request()->get('recordId'),
    'meta'       => Request()->get('meta'),
    'pagination' => Pagination()
]);
