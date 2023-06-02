<?php

namespace Project;

use ApCode\Misc\Pagination;

trait Files
{
    function files($params = [], Pagination $pagination = null)
    {
        return FileRepository::findMany($params + ['parentType' => $this::tableName(), 'parentId' => $this->id() ?: -1], $pagination);
    }

    function newFile()
    {
        $file = File::getInstance();
        $file->setParentType($this::tableName());
        $file->setParentId($this->id());

        return $file;
    }
}
