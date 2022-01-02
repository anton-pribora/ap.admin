<?php

ob_start();

$asset = Asset(__dir('img'));

?>
<div class="text-center">
  <h3>Вы не можете удалить себя!</h3>
  <img class="img-responsive img-rounded" style="margin: 0 auto" src="<?php echo $asset?>/omg.jpg" />
  <p>Попросите кого-нибудь удалить ваш профиль.</p>
</div>
<?php 

ReturnJson([
    'title'   => 'OMG',
    'content' => ob_get_clean(),
    'large'   => false,
]);