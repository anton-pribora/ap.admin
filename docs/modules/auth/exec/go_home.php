<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

if (Identity()->isEmpty()) {
    return $this->execute('login.php');
}

Redirect(ExpandUrl('@root/consultant/'));