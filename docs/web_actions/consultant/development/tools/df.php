<?php

Layout()->setVar('title', 'Свободное место');

?>
<pre><?php passthru('df -h');?></pre>