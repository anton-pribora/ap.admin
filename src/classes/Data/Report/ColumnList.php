<?php

namespace Data\Report;

class ColumnList
{
    private $columns = [];

    /**
     * @return \Data\Report\Column[]
     */
    public function columns()
    {
        return $this->columns;
    }

    /**
     * @return \Data\Report\Column
     */
    public function createColumn($key = NULL, $title = NULL, array $params = NULL)
    {
        if (is_null($key)) {
            $key = count($this->columns);
        }

        $column = new Column($key, $title, $params);
        $this->columns[ $key ] = $column;

        return $column;
    }

    public function hasColumn($key)
    {
        return isset($this->columns[$key]);
    }

    public function column($key)
    {
        return isset($this->columns[$key]) ? $this->columns[$key] : null;
    }
}
