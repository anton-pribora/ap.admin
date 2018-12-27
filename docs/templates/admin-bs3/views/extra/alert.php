<?php

/**
 * @var ApCode\Template\Template $this
 */
$message = $this->argument(0);
$class   = $this->param('class', 'warning');

?>
<div class="alert alert-<?php echo $class?>" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <?php echo $message?>
</div>