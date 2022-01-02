<?php
/* @var $this ApCode\Template\Template */
/* @var $report Data\Report */
$report = $this->argument(0);

$displayRowNumber = $this->param('displayRowNumber', true);

$showTotal    = false;
$totals       = [];

$i = 0;

foreach ($report->columns() as $column) {
    if ($column->param('calcTotalSum')) {
        if (!$showTotal) {
            $showTotal = true;
        }
        
        $totals[$column->key()] = null;
    }
}

$i = 1;

?>
<table class="table table-striped table-bordered table-hover table-condensed">
<?php if ($report->title()) {?>
  <caption><?php echo $report->title();?></caption>
<?php }?>

<thead>
  <tr>
<?php if ($displayRowNumber) {?>
    <th></th>
<?php }?>
<?php foreach ($report->columns() as $column) {?>
    <th><?php echo $column->title()?></th>
<?php }?>
  </tr>
</thead>
  
<tbody>
<?php foreach ($report->rows() as $row) {?>
  <tr>
<?php if ($displayRowNumber) {?>
    <th style="width: 1px;"><?php echo $i ++?></th>
<?php }?>
<?php 
foreach ($report->columns() as $column) {
    if ($column->param('calcTotalSum')) {
        $report->totalRow()->increaseValue($column->key(), $row->getValue($column->key()));
    }
    
    $value = $row->getValue($column->key());
    
    $function = $row->getParam($column->key(), 'formatFunction') ?: $column->param('formatRowFunction') ?: $column->param('formatFunction');
    
    if ($function) {
        $value = $function($value, $row->getParams($column->key()));
    }
    
    $style = $row->getParam($column->key(), 'style', '');
    
    if ($row->getParam($column->key(), 'nowrap') || $column->param('nowrap')) {
        $style = 'white-space:nowrap; '. $style;
    }
    
?>
    <td style="<?php echo $style?>">
<?php if ($row->getParam($column->key(), 'href')) { ?>
      <a href="<?php echo Html($row->getParam($column->key(), 'href'))?>"><?php echo $value?></a>
<?php } else {?>
      <?php echo $value?>
<?php }?>
    </td>
<?php 
}
?>
  </tr>
<?php }?>
</tbody>

<?php if (!$report->totalRow()->isEmpty()) {?>
<?php $row = $report->totalRow()?>
<tfoot>
  <tr>
<?php if ($displayRowNumber) {?>
    <th></th>
<?php }?>
<?php 
foreach ($report->columns() as $column) {
    $value = $row->getValue($column->key());
    
    $function = $row->getParam($column->key(), 'formatFunction') ?: $column->param('formatRowFunction') ?: $column->param('formatFunction');
    
    if ($function) {
        $value = $function($value, $row->getParams($column->key()));
    }
    
    $style = $row->getParam($column->key(), 'style', '');
    
    if ($row->getParam($column->key(), 'nowrap') || $column->param('nowrap')) {
        $style = 'white-space:nowrap; '. $style;
    }
?>
    <th style="<?php echo $style?>">
<?php if ($row->getParam($column->key(), 'href')) { ?>
      <a href="<?php echo Html($row->getParam($column->key(), 'href'))?>"><?php echo $value?></a>
<?php } else {?>
      <?php echo $value?>
<?php }?>
    </th>
<?php 
}
?>
  </tr>
</tfoot>
<?php }?>
</table>