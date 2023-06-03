<?php

/* @var $this ApCode\Template\Template */
/* @var $record Project\Profile */

$record = $this->argument(0);

?>
<div class="row widget">
  <div class="col-md-7">
    <?php echo Widget('profile.information', $record, $this->paramList())?>
  </div>
</div>
