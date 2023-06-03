<?php

/* @var $this ApCode\Template\Template */
/* @var $list Project\Role[] */

$list = $this->argument(0);
$startFrom = $this->argument(1);

foreach ($list as $i => $item) {
?>
<div class="mb-3">
  <div class="d-flex align-items-stretch">
    <div style="min-width: 80px">
      <svg class="bd-placeholder-img img-fluid rounded" width="80" height="80" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect></svg>
    </div>
    <div class="flex-fill">
      <div class="ms-3">
        <h5 class="card-title"><?=$item->urlAsset('link.view')?> <small class="text-muted ms-3">#<?=$item->id()?></small></h5>
        <div><span class="text-muted">Коротая метка:</span> <?=Html($item->tag())?></div>
        <div><span class="text-muted">Описание:</span> <?=Html($item->comment())?></div>

      </div>
    </div>
  </div>
</div>
<?php
}
