<?php

/* @var $this ApCode\Template\Template */
/* @var $record Project\Profile */

$record = $this->argument(0);

if ($record->del()) {
    Alert('Запись отмечена как удалённая', 'warning');
}

?>
<div class="row widget">
  <div class="col-md-7">
    <?php echo Widget('profile.information', $record, $this->paramList())?>
    <br />
    <?php echo Widget('profile.files', $record, $this->paramList())?>
  </div>
  <div class="col">
    <?php echo Widget('profile.roles', $record, $this->paramList())?>
    <br />
    <?php echo Widget('profile.password', $record, $this->paramList())?>
  </div>
</div>
