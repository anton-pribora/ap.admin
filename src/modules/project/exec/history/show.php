<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */
/* @var $pagination \ApCode\Misc\Pagination */

$section    = $this->param('section');
$recordId   = $this->param('recordId');
$pagination = $this->param('pagination');
$meta       = (array) $this->param('meta');

$decoded = ssl_decode($section);

if (is_null($decoded) || !isset($decoded['_']) || !key_exists('v', $decoded)) {
    Alert('Invalid section', 'danger');
    return true;
}

$section = $decoded['_'];
$viewAll = $decoded['v'];

$profileId = $this->param('profileId');
$companyId = null;

if ($viewAll === false) {
    $profileId = Consultant()->id();
} elseif (is_array($viewAll)) {
    $companyId = $viewAll;
}

$table ="{$section}_history";

$rows = [];

if (Db()->tableExists($table)) {
    $whereClause = [];

    if ($recordId) {
        $whereClause[] = 'record_id = ' . Db()->quote($recordId);
    }

    if ($profileId) {
        $whereClause[] = 'profile_id = ' . Db()->quote($profileId ?: -1);
    }

    if ($companyId) {
        $whereClause[] = 'company_id IN (' . join(', ', Db()->quoteArray((array) $companyId) ?: ['-1']) . ')';
    }

    foreach ($meta as $key => $value) {
        $whereClause[] = 'json_unquote(json_extract(meta, \'$.' . $key . '\')) = ' . Db()->quote($value);
    }

    $sql = '
SELECT SQL_CALC_FOUND_ROWS 
    `date`,
    `text`,
    `meta`

FROM 
    ' . Db()->quoteName($table) . ' 
    
WHERE ' . join(' AND ', $whereClause ?: [1]) . ' 
ORDER BY id DESC 
LIMIT ' . intval($pagination->startFrom()) . ', ' . intval($pagination->limit());

//    echo new \ApCode\Html\Element\Pre($sql);

    $rows = Db()->query($sql)->fetchAllRows();

    $pagination->setTotalItems(Db()->query('SELECT FOUND_ROWS()')->fetchValue());
}

Layout()->append('head.css.code', <<<CSS
ol, ul {
    margin-bottom: 0;
}
CSS);

$replaceIcons = function ($text) {
    $icons = Module('misc')->execute('lib/project/contacts/icons.php');

    unset($icons['default']);
    $re = [];

    foreach ($icons as $type => $icon) {
        $re[":{$type}:"] = $icon;
    }

    return strtr($text, $re);
};

$hl = function ($text) {
    return preg_replace_callback('~<pre class="u?diff">([\s\S]+)</pre>~', function ($matches) {
        return '<pre class="diff">' . preg_replace(['~^\+.*~m', ' ~^-.*~m'], ['<span class="w-75 fw-bold d-inline-block" style="background-color: #dfe">$0</span>', '<span class="w-75 fw-bold d-inline-block" style="background-color: #fdd">$0</span>'], $matches[1]) . '</pre>';
    }, $text);
};

Template()->render('@pagination', $pagination);

?>
<table class="table mx-1">
  <tr>
    <th>Дата</th>
    <th>Действие</th>
<!--    <th>meta</th>-->
  </tr>
<?php
foreach ($rows as $row) {
    [$date, $time] = explode('+', intl_date('d MMM y+HH:mm:ss', $row['date']));
?>
  <tr>
    <td><?=$date?> <span class="text-body-secondary small ms-2"><?=$time?>&nbsp;<?=(new DateTime())->format('T')?></span></td>
    <td><?=$hl($replaceIcons($row['text']))?></td>
  </tr>
<?php } ?>
</table>

<?php

Template()->render('@pagination', $pagination);
