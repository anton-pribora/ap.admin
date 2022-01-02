<?php

/**
 * @var ApCode\Template\Template $this
 */
$message = $this->argument(0);
$class   = $this->param('class', 'warning');

?>
<div class="alert alert-<?php echo $class?> alert-dismissible fade show" role="alert">
  <?php echo $message?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
