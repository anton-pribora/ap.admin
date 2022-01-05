<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', 'Слоны');
Layout()->append('breadcrumbs', new A('Слоны', ShortUrl(__dir('/'))));
