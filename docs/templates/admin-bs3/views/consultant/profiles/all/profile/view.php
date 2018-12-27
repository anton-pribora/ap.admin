<?php

/* @var $this ApCode\Template\Template */
/* @var $profile \Site\Consultant */
$profile = $this->argument(0);

if ($profile->isDeleted()) {
    Alert('Пользователь удлён. Вы не можете его редактировать.', 'danger');
}

?>
<div class="row widgets">
  <div class="col-md-7">
    <?php echo Widget('consultant.information', $profile, $this->params)?>
  </div>
  <div class="col-md-5">
  </div>
</div>
