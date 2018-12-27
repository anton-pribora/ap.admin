<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

use ApCode\Web\Pagination;

class FileRepository
{
    /**
     * @param array $params
     * @param Pagination $pagination
     * @return \Site\File[]
     */
    public static function findMany($params, Pagination $pagination = NULL)
    {
        $params = array_filter($params);
        
        $where   = self::buildWhere($params);
        $orderBy = self::buildOrderBy($params);

        if (!empty($params)) {
            throw new \Exception('Invalid param(s) '. join(', ', array_keys($params)));
        }
        
        $sql = 'SELECT SQL_CALC_FOUND_ROWS "id" FROM "'. Item::tableName() .'"';

        if ($where) {
            $sql .= ' WHERE '. join(" AND ", $where);
        }

        if ($orderBy) {
            $sql .= ' ORDER BY '. join(', ', $orderBy);
        }

        if ($pagination && $pagination->limit()) {
            $sql .= ' LIMIT '. intval($pagination->startFrom()) .', '. intval($pagination->limit());
        }

        $idList = Db()->query($sql)->fetchColumn();

        if ($pagination) {
            $pagination->setTotalItems(Db()->query('SELECT FOUND_ROWS()')->fetchValue());
        }

        $result = [];

        foreach ($idList as $id) {
            $result[] = File::getInstance($id);
        }

        return $result;
    }

    /**
     * @param array $params
     * @return \Site\File
     */
    public static function findOne($params)
    {
        $pagination = new Pagination(['limit' => 1]);
        $list = self::findMany($params, $pagination);

        return current($list);
    }
    
    public static function drop(File $file)
    {
        ItemRepository::drop($file);
    }

    private static function buildWhere(&$params)
    {
        $where = [];
        
        $where[] = '"type" = \'file\'';
        
        if (isset($params['id'])) {
            $where[] = '"id" = '. Db()->quote($params['id']);
            unset($params['id']);
        }
        
        if (isset($params['parentItemId'])) {
            $where[] = '"parent_item_id" = '. Db()->quote($params['parentItemId']);
            unset($params['parentItemId']);
        }
        
        if (isset($params['gotcha'])) {
            $gotchaClause = $params['gotcha'];
            unset($params['gotcha']);
        } else {
            $gotchaClause = [];
        }
        
        if (isset($params['group'])) {
            $gotchaClause[] = ['file.group', $params['group'], '='];
            unset($params['group']);
        }
        
        if ($gotchaClause) {
            $list = Gotcha()->find($gotchaClause);
            $where[] = $list ? '"ID" IN ('. join(',', $list) .')' : '0';
        }
        
        return $where;
    }
    
    private static function buildOrderBy(&$params)
    {
        $orderBy = [];
        
        $ascdesc = function($var, $default) {
            switch (mb_strtolower($var)) {
                case 'asc': return 'ASC';
                case 'desc': return 'DESC';
            }
            return $default;
        };

        if (isset($params['order_by']['date'])) {
            $orderBy[] = '"date" '. $ascdesc($params['order_by']['date'], 'ASC');
            unset($params['order_by']['date']);
        }
        
        if (empty($params['order_by'])) {
            unset($params['order_by']);
        }

        return $orderBy;
    }
}