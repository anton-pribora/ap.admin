<?php 

RequireLib('angularjs');
RequireLib('datetimepicker');

Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/datetimepicker.js')));