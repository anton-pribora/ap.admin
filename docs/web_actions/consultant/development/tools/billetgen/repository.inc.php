<?php

if (false) {
    $qname = '';        // Полное имя класса, включая пространство имён
    $fname = '';        // Полное имя файла, в котором будет класс, не включая расширения
    $cname = '';        // Имя класса без пространства имён
    $nname = '';        // Пространство имён
    
    $idfield   = '';    // Название столбца с id в таблице
    $fieldsMap = [];    // Карта полей
}

$where   = [];
$orderBy = '';

foreach ($fieldsMap as $prop => $field) {
    $where[] = <<<IF
        
        if (isset(\$params['{$prop}'])) {
            \$where[] = '"{$field['field']}" = '. Db()->quote(\$params['{$prop}']);
            unset(\$params['{$prop}']);
        }

IF;
            
    if (empty($orderBy) && preg_match('~(name|title)~', $prop)) {
        $orderBy = '$orderBy[] = \'"'. $field['field'] .'"\';';
    }
}
    
$where = join($where);

return <<<EOF
<?php

namespace {{class | namespace}};

use ApCode\Web\Pagination;

class {{class | class}}Repository
{
    /**
     * @param array \$params
     * @param Pagination \$pagination
     * @return \\{{class}}[]
     */
    public static function findMany(\$params, Pagination \$pagination = NULL)
    {
        \$params = array_filter(\$params);
        
        \$where   = self::buildWhere(\$params);
        \$orderBy = self::buildOrderBy(\$params);

        if (!empty(\$params)) {
            throw new \Exception('Invalid param(s) '. join(', ', array_keys(\$params)));
        }
        
        \$sql = 'SELECT SQL_CALC_FOUND_ROWS "{$idfield}" FROM "'. {{class | class}}::tableName() .'"';

        if (\$where) {
            \$sql .= ' WHERE '. join(" AND ", \$where);
        }

        if (\$orderBy) {
            \$sql .= ' ORDER BY '. join(', ', \$orderBy);
        }

        if (\$pagination && \$pagination->limit()) {
            \$sql .= ' LIMIT '. intval(\$pagination->startFrom()) .', '. intval(\$pagination->limit());
        }

        \$idList = Db()->query(\$sql)->fetchColumn();

        if (\$pagination) {
            \$pagination->setTotalItems(Db()->query('SELECT FOUND_ROWS()')->fetchValue());
        }

        \$result = [];

        foreach (\$idList as \$id) {
            \$result[] = {{class | class}}::getInstance(\$id);
        }

        return \$result;
    }

    /**
     * @param array \$params
     * @return \\{{class}}
     */
    public static function findOne(\$params)
    {
        \$pagination = new Pagination();
        \$pagination->setLimit(1);

        \$list = self::findMany(\$params, \$pagination);

        return current(\$list);
    }

    /**
     * @param \\{{class}} \$item
     */
    public static function drop(\\{{class}} \$item)
    {
        \$sql = 'DELETE FROM ' . Db()->quoteName(\$item::tableName()) . ' WHERE "{$idfield}" = ?';
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
EOF
;                
