<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$photo = $record->photo();

$smallPhoto = $photo->id() ? $photo->thumbnail('medium') : new \Data\DefaultProfilePhotoThumbnail();
$largePhoto = $photo->id() ? $photo->thumbnail('big') : false;

return [
    'id'   => $record->id(),
    'name' => [
        'first'  => $record->firstName(),
        'last'   => $record->lastName(),
        'middle' => $record->middleName(),
        'full'   => $record->fullName(),
    ],
    'photo'   => [
        'small' => $smallPhoto,
        'large' => $largePhoto,
    ],
    'post'     => $record->post(),
    'contacts' => $record->contactsRaw(),
    'comment'  => $record->comment(),
];
