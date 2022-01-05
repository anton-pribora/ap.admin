<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$cwd = $this->param('cwd');

$folder = strtr(basename(__FILE__), ['.php' => '']);

$folder = ".{$folder}";

$this->param('startSection')("{$folder}/");
$this->setParam('cwd', "{$cwd}/{$folder}");
$this->param('globInclude')(__dir("{$folder}/*.php"));
$this->param('endSection')();

$this->setParam('cwd', $cwd);
