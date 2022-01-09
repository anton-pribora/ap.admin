<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', 'Employee');
Layout()->append('breadcrumbs', new A('Employee', ShortUrl(__dir('/'))));
