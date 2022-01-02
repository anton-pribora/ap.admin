<?php

use ApCode\Html\Element\Div;

/* @var $this ApCode\Template\Template */
/* @var $pagination Pagination */
$pagination = $this->argument(0);
$extra      = $this->param('extra', []);

?>
<div class="text-secondary">
  <ul class="list-inline">
    <li class="list-inline-item">Найдено: <?php echo number_format($pagination->totalItems())?></li>
<?php foreach ($extra as $name => $value) {?>
    <li class="list-inline-item"><?php echo $name?>: <?php echo $value?></li>
<?php }?>
  </ul>
</div>
