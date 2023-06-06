<?php
/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$result = [];

foreach ($record->files(['subFolder' => 'profile_files']) as $attachment) {
    $result[] = $this->execute('encodeData.php', $attachment);
}

return $result;
