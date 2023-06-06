<?php

/* @var $this ApCode\Template\Template */
/* @var $record Project\Role */

$record = $this->argument(0);

if ($record->del()) {
    Alert('Запись отмечена как удалённая', 'warning');
}

?>
<div class="row widget">
  <div class="col-md-7">
    <?php echo Widget('role.information', $record, $this->paramList())?>
  </div>
</div>
