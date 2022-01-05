<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$cwd = $this->param('cwd');

$this->param('startSection')("Файлы раздела:");
$this->param('globInclude')(__dir('section/*.php'));
$this->param('endSection')();

$this->setParam('cwd', $cwd);
