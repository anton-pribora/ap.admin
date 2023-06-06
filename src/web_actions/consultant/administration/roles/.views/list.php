<?php

/* @var $this ApCode\Template\Template */
/* @var $list Project\Role[] */

$list = $this->argument(0);
$startFrom = $this->argument(1);

foreach ($list as $i => $item) {
?>
<div class="mb-3">
  <div class="d-flex align-items-stretch">
    <div class="flex-fill">
      <div class="">
        <h5 class="card-title"><?=$item->urlAsset('link.view')?> <small class="text-body-secondary ms-3">#<?=$item->id()?></small></h5>
        <div><span class="text-body-secondary">Коротая метка:</span> <?=Html($item->tag())?></div>
        <div><span class="text-body-secondary">Описание:</span> <?=Html($item->comment())?></div>
      </div>
    </div>
  </div>
</div>
<?php
}
