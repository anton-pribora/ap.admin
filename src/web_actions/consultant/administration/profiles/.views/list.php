<?php

/* @var $this ApCode\Template\Template */
/* @var $list Project\Profile[] */

$list = $this->argument(0);
$startFrom = $this->argument(1);

foreach ($list as $i => $item) {
    $photo = $item->photo();
    $smallPhoto = $photo->id() ? $photo->thumbnail('small') : new \Data\DefaultProfilePhotoThumbnail();

?>
<div class="mb-3">
  <div class="d-flex align-items-stretch">
    <div style="min-width: 64px">
      <img class="rounded-2" src="<?=$smallPhoto->shortUrl()?>" width="64">
    </div>
    <div class="flex-fill">
      <div class="ms-3">
        <h5 class="card-title"><?=$item->urlAsset('link.view')?> <small class="text-body-secondary ms-3">#<?=$item->id()?></small></h5>
        <div><span class="text-body-secondary">Должность:</span> <?=Html($item->post())?></div>
      </div>
    </div>
  </div>
</div>
<?php
}
