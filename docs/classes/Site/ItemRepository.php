<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

use ApCode\Web\Pagination;
use Gotcha\GotchaRecordInterface;
use Replica\ReplicaRecordInterface;

class ItemRepository
{
    /**
     * @param array $params
     * @param Pagination $pagination
     * @return \Site\Item[]
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
            $result[] = Item::getInstance($id);
        }

        return $result;
    }

    /**
     * @param array $params
     * @return \Site\Item
     */
    public static function findOne($params)
    {
        $pagination = new Pagination(['limit' => 1]);
        $list = self::findMany($params, $pagination);

        return current($list);
    }
    
    public static function drop(Item $item)
    {
        Module('site')->execute('thumbnail/remove.php', $item);
        
        if ($item instanceof GotchaRecordInterface) {
            Gotcha()->removeRecord($item);
        }
        
        if ($item instanceof ReplicaRecordInterface) {
            Replica()->delete($item);
        }
        
        $sql = 'DELETE FROM "site_item_meta" WHERE "item_id" = ?';
        Db()->query($sql, [$item->id()]);
        
        $sql = 'DELETE FROM "'. Item::tableName() .'" WHERE "id" = ?';
        Db()->query($sql, [$item->id()]);
    }

    private static function buildWhere(&$params)
    {
        $where = [];
        
        if (isset($params['id'])) {
            $where[] = '"id" = '. Db()->quote($params['id']);
            unset($params['id']);
        }
        
        if (isset($params['date'])) {
            $where[] = '"date" = '. Db()->quote($params['date']);
            unset($params['date']);
        }
        
        if (isset($params['type'])) {
            $where[] = '"type" = '. Db()->quote($params['type']);
            unset($params['type']);
        }
        
        if (isset($params['parentItemId'])) {
            $where[] = '"parent_item_id" = '. Db()->quote($params['parentItemId']);
            unset($params['parentItemId']);
        }
        
        if (isset($params['del'])) {
            $where[] = '"del" = '. Db()->quote($params['del']);
            unset($params['del']);
        } else {
            $where[] = '"del" = 0';
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
            $orderBy[] = '"date" '. $ascdesc($params['order_by']['date'], 'DESC');
            unset($params['order_by']['date']);
        }
        
        if (empty($params['order_by'])) {
            unset($params['order_by']);
        }

        return $orderBy;
    }
}