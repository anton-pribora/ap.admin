<?php

/* @var $this ApCode\Template\Template */
/* @var $list Site\Consultant[] */
$list = $this->argument(0);
$startFrom = $this->argument(1);

Widget('info::enable');

?>
<style>
<!--
@media (min-width: 560px) {
  .span-divider {
    margin: 0px 20px;
  }
}

@media (max-width: 560px) {
  .span-divider {
    display: block;
  }
}
-->
</style>
<?php

foreach ($list as $i => $item) {
    $thumbnailSmall = $item->thumbnail('small');
    $info = $item->info();
?>
<div class="media">
  <div class="media-left">
    <a href="javascript:angular.element(document).injector().get('infoService').display('consultant', {consultantId: <?php echo $item->id()?>});">
      <img class="img-rounded" width="64" src="<?php echo $thumbnailSmall->url()?>" alt="...">
    </a>
  </div>
  <div class="media-body">
    <div class="media-heading">
      <h4 style="margin-top: 0px;">
        <?php echo $item->urlAsset('link.view')?>
      </h4>
    </div>
    <h5><?php echo $info->post();?></h5>
    <p>
      <span class="text-muted" style="margin-right: 5px">Email:</span> <?php echo activateUrls($info->email())?>
      <span class="span-divider"></span>
      <span class="text-muted" style="margin-right: 5px">Skype:</span> <?php echo activateUrls($info->skype())?>
      <span class="span-divider"></span>
      <span class="text-muted" style="margin-right: 5px">Роль:</span> <?php echo activateUrls($item->roleName())?>
      <span class="span-divider"></span>
    </p>
  </div>
</div>
<?php
}
