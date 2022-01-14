<?php

/* @var $this ApCode\Template\Template */
/* @var $record Project\Examples\Employee */

$record = $this->argument(0);

?>
<div class="row widget">
  <div class="col-md-7">
    <?php echo Widget('examples.employee.information', $record, $this->paramList())?>
  </div>
</div>

<div class="widget mt-4">
  <?php echo Widget('examples.employee.files', $record, $this->paramList())?>
</div>
