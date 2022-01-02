<?php
/* @var $this ApCode\Template\Template */
/* @var $report Data\Report */
$report = $this->argument(0);

$fp = fopen('php://output', 'w');

$csv = function ($fields) use ($fp) {
    fputcsv($fp, $fields);
};

$columns = [];

foreach ($report->columns() as $column) {
    $columns[] = $column->title();
}

$csv($columns);

foreach ($report->rows() as $row) {
    $data = [];
    
    foreach ($report->columns() as $column) {
        $data[] = $row->getValue($column->key());
    }
    
    $csv($data);
}

fclose($fp);
