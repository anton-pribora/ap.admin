<?php

Layout()->appendOnce('body.js.code', file_get_contents(__dir('dist/controller.js')));
Layout()->appendOnce('content.end.html', file_get_contents(__dir('dist/dialog.html')));
