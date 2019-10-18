<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

use ApCode\Web\Pagination;

class LoginRepository
{
    /**
     * @param array $params
     * @param Pagination $pagination
     * @return []
     */
    public static function findMany($params, Pagination $pagination = NULL)
    {
        $params = array_filter($params);
        
        $where   = self::buildWhere($params);
        $orderBy = self::buildOrderBy($params);

        if (!empty($params)) {
            throw new \Exception('Invalid param(s) '. join(', ', array_keys($params)));
        }
        
        $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM "site_login"';

        if ($where) {
            $sql .= ' WHERE '. join(" AND ", $where);
        }

        if ($orderBy) {
            $sql .= ' ORDER BY '. join(', ', $orderBy);
        }

        if ($pagination && $pagination->limit()) {
            $sql .= ' LIMIT '. intval($pagination->startFrom()) .', '. intval($pagination->limit());
        }

        $list = Db()->query($sql)->fetchAllRows();

        if ($pagination) {
            $pagination->setTotalItems(Db()->query('SELECT FOUND_ROWS()')->fetchValue());
        }

        return $list;
    }

    /**
     * @param array $params
     * @return []
     */
    public static function findOne($params)
    {
        $pagination = new Pagination();
        $pagination->setLimit(1);

        $list = self::findMany($params, $pagination);

        return current($list);
    }

    private static function buildWhere(&$params)
    {
        $where = [];
        
        if (isset($params['id'])) {
            $where[] = '"id" = '. Db()->quote($params['id']);
            unset($params['id']);
        }
        
        if (isset($params['id!='])) {
            $where[] = '"id" != '. Db()->quote($params['id!=']);
            unset($params['id!=']);
        }
        
        if (isset($params['login'])) {
            $where[] = '"login" = '. Db()->quote($params['login']);
            unset($params['login']);
        }
        
        if (isset($params['type'])) {
            $where[] = '"type" = '. Db()->quote($params['type']);
            unset($params['type']);
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

        
        
        if (empty($params['order_by'])) {
            unset($params['order_by']);
        }

        return $orderBy;
    }
}