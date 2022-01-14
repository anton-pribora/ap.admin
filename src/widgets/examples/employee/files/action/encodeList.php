<?php
/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$result = [];

foreach ($record->attachments() as $attachment) {
    $result[] = $this->execute('encodeData.php', $attachment);
}

return $result;
