<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$icons = [];

$view = file_get_contents(__dir('dist/contactsView.js'));
preg_match('~icons = (\{[^}]+})~', $view, $matches);
$text = $matches[1];

$text = strtr($text, ['"' => "'", "'" => '"']);
$text = preg_replace('/^(\s+)(\w+):/m', '$1"$2":', $text);

$json = json_decode_array($text);

foreach ($json as $key => $value) {
    $icons[$key] = "<i class='$value'></i>";
}

return $icons;
