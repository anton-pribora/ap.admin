<?php

/* @var $this ApCode\Template\Template */
$list = $this->argument(0);

?>
<ul class="list-inline">
<?php foreach ($list as $item) {?>
	<li><?php echo $item?></li>
<?php }?>
</ul>