<?php

/**
 * @var ApCode\Template\Template $this
 */
$tabs = $this->argument(0);

$uniqid = uniqid('_');


?>
<div class="widgets">
  <ul class="nav nav-tabs">
<?php foreach ($tabs as $id => $tab) {?>
    <li class="<?php echo !empty($tab['active']) ? 'active' : ''; ?>"><a href="#widget<?php echo $uniqid?>_<?php echo $id?>" data-toggle="tab"><?php echo $tab['title']?></a></li>
<?php }?>
  </ul>
  <div class="tab-content">
<?php foreach ($tabs as $id => $tab) {?>
    <div class="tab-pane <?php echo !empty($tab['active']) ? 'active' : ''; ?>" id="widget<?php echo $uniqid?>_<?php echo $id?>">
      <?php echo $tab['content'];?>
    </div>
<?php }?>
  </div>
</div>
<?php
