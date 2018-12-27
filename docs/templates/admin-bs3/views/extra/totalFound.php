<?php

use ApCode\Html\Element\Div;

/* @var $this ApCode\Template\Template */
/* @var $pagination Pagination */
$pagination = $this->argument(0);
$extra      = $this->param('extra', []);

?>
<div class="help-block" style="margin-bottom: 0px;">
  <ul class="list-inline">
    <li>Найдено: <?php echo number_format($pagination->totalItems())?></li>
<?php foreach ($extra as $name => $value) {?>
    <li><?php echo $name?>: <?php echo $value?></li>
<?php }?>
  </ul>
</div>
