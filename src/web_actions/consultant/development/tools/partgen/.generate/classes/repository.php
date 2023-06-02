<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$cwd             = $this->param('cwd');
$name            = $this->param('part.name');
$table           = $this->param('part.table');
$billetClass     = $this->param('part.billet');
$repositoryClass = $this->param('part.repository');
$fields          = $this->param('fields');

$qname = $repositoryClass;                      // Полное имя класса, включая пространство имён
$fname = strtr($qname, '\\', '/');              // Полное имя файла, в котором будет класс, не включая расширения
$cname = basename($fname);                      // Имя класса без пространства имён
$nname = strtr(dirname($fname), '/', '\\');     // Пространство имён

$billetClass = preg_replace('~' . preg_quote($nname) . '\\\\?~', '', $billetClass);

$where   = [];
$orderBy = '';

$idfield = isset($fields['id']) ? 'id' : key($fields);
$orderBy = '$orderBy[] = \'' . Db()->quoteName($idfield) . ' DESC\';';

foreach ($fields as $dbField => ['prop' => $prop, 'format' => $format, 'search' => $search]) {
    $quotedField = Db()->quoteName($dbField);

    if ($search) {
        if ($format === 'text' || $format === 'string') {
            $where[] = <<<PHP

        if (isset(\$params['{$prop}'])) {
            \$where[] = '{$quotedField} LIKE ' . Db()->quote('%' . \$params['{$prop}'] . '%');
            unset(\$params['{$prop}']);
        }

PHP;
        } elseif ($format === 'del') {
            $where[] = <<<PHP

        if (isset(\$params['{$prop}'])) {
            if (!in_array(\$params['{$prop}'], ['any', 'all'])) {
                \$where[] = '{$quotedField} = ' . Db()->quote(\$params['{$prop}']);
                unset(\$params['{$prop}']);
            }
        } else {
            \$where[] = '{$quotedField} = 0';
        }

PHP;
        } else {
            $where[] = <<<PHP

        if (isset(\$params['{$prop}'])) {
            \$where[] = '{$quotedField} = ' . Db()->quote(\$params['{$prop}']);
            unset(\$params['{$prop}']);
        }

PHP;
        }
    }
}

$where = join($where);
$quotedIdfield = Db()->quoteName($idfield);

$data = <<<PHP
<?php

namespace $nname;

use ApCode\Web\Pagination;

class {$cname}
{
    /**
     * @param array \$params
     * @param Pagination \$pagination
     * @return {$billetClass}[]
     */
    public static function findMany(\$params, Pagination \$pagination = NULL)
    {
        \$params = array_filter(\$params);

        \$where   = self::buildWhere(\$params);
        \$orderBy = self::buildOrderBy(\$params);

        if (!empty(\$params)) {
            throw new \Exception('Invalid param(s) ' . join(', ', array_keys(\$params)));
        }

        \$sql = 'SELECT SQL_CALC_FOUND_ROWS {$quotedIdfield} FROM ' . Db()->quoteName({$billetClass}::tableName());

        if (\$where) {
            \$sql .= ' WHERE ' . join(' AND ', \$where);
        }

        if (\$orderBy) {
            \$sql .= ' ORDER BY ' . join(', ', \$orderBy);
        }

        if (\$pagination && \$pagination->limit()) {
            \$sql .= ' LIMIT ' . intval(\$pagination->startFrom()) . ', ' . intval(\$pagination->limit());
        }

        \$idList = Db()->query(\$sql)->fetchColumn();

        if (\$pagination) {
            \$pagination->setTotalItems(Db()->query('SELECT FOUND_ROWS()')->fetchValue());
        }

        \$result = [];

        foreach (\$idList as \$id) {
            \$result[] = {$billetClass}::getInstance(\$id);
        }

        return \$result;
    }

    /**
     * @param array \$params
     * @return {$billetClass}
     */
    public static function findOne(\$params)
    {
        \$pagination = new Pagination();
        \$pagination->setLimit(1);

        \$list = self::findMany(\$params, \$pagination);

        return current(\$list);
    }

    /**
     * @param {$billetClass} \$item
     */
    public static function drop({$billetClass} \$item)
    {
        \$sql = 'DELETE FROM ' . Db()->quoteName(\$item::tableName()) . ' WHERE {$quotedIdfield} = ?';
        Db()->query(\$sql, [\$item->billetId()]);
    }

    private static function buildWhere(&\$params)
    {
        \$where = [];
{$where}
        return \$where;
    }

    private static function buildOrderBy(&\$params)
    {
        \$orderBy = [];

        \$ascdesc = function(\$var, \$default) {
            switch (mb_strtolower(\$var)) {
                case 'asc': return 'ASC';
                case 'desc': return 'DESC';
            }
            return \$default;
        };

        {$orderBy}

        if (empty(\$params['order_by'])) {
            unset(\$params['order_by']);
        }

        return \$orderBy;
    }
}
PHP;

$fullPath = $cwd . '/' . $fname . '.php';

$this->param('printIndent')(basename($fullPath) . ' ... ');
if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
