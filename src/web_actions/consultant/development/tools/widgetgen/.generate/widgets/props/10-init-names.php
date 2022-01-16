<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$widgetPath = $this->param('widget.path');
$widgetName = $this->param('widget.name');

$fullPath = "{$widgetPath}.{$widgetName}";

$prefix = preg_replace_callback('/\.(\w)/', function ($matches) {
    return ucfirst($matches[1]);
}, $fullPath);

$componentNamePrefix = preg_replace_callback('/[A-Z]/', function ($matches) {
    return '-' . lcfirst($matches[0]);
}, lcfirst($prefix));

$this->setParam('widget.store', $prefix);
$this->setParam('widget.fullPath', $fullPath);
$this->setParam('widget.componentNamePrefix', $componentNamePrefix);
$this->setParam('widget.component.viewForm', $componentNamePrefix . '-view-form');
$this->setParam('widget.templateId.viewForm', $prefix . 'ViewForm');
$this->setParam('widget.component.editDialog', $componentNamePrefix . '-edit-dialog');
$this->setParam('widget.templateId.editDialog', $prefix . 'EditDialog');
