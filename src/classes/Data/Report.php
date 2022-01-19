<?php

namespace Data;

class Report
{
    private $title;
    private $columns;

    /**
     * @var Report\Row[]
     */
    private $rows = [];

    /**
     * @var Report\Row
     */
    private $totalRow = [];

    public function __construct($title = NULL)
    {
        $this->title    = $title;
        $this->columns  = new Report\ColumnList();
        $this->totalRow = new Report\Row();
    }

    public function title()
    {
        return $this->title;
    }

    public function addColumn($key, $title = NULL, array $params = NULL)
    {
        if (is_null($title)) {
            $title = $key;
        }

        $this->columns->createColumn($key, $title, $params);
        return $this;
    }

    /**
     * @return \Data\Report\Column
     */
    public function column($columnKey)
    {
        return $this->columns->column($columnKey);
    }

    public function columns()
    {
        return $this->columns->columns();
    }

    public function makeRow()
    {
        return new Report\Row();
    }

    public function addRow(Report\Row $row)
    {
        $this->rows[] = $row;
    }

    public function addFooterRow(Report\Row $row)
    {
        $this->footerRows[] = $row;
    }

    /**
     * @return \Data\Report\Row[]
     */
    public function rows()
    {
        return $this->rows;
    }


    /**
     * @return \Data\Report\Row
     */
    public function totalRow()
    {
        return $this->totalRow;
    }
}
