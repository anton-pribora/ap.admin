<?php

/* @var $this ApCode\Template\Template */

foreach (PopAlerts() as list($alert, $type)) {
    $this->render('@extra/alert.php', $alert, ['class' => $type]);
}