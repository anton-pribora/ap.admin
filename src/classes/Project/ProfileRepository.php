<?php

namespace Project;

use ApCode\Web\Pagination;

class ProfileRepository
{
    /**
     * @param array $params
     * @param Pagination $pagination
     * @return Profile[]
     */
    public static function findMany($params, Pagination $pagination = NULL)
    {
        $params = array_filter($params);

        $where   = self::buildWhere($params);
        $orderBy = self::buildOrderBy($params);

        if (!empty($params)) {
            throw new \Exception('Invalid param(s) ' . join(', ', array_keys($params)));
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS `id` FROM ' . Db()->quoteName(Profile::tableName());

        if ($where) {
            $sql .= ' WHERE ' . join(' AND ', $where);
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . join(', ', $orderBy);
        }

        if ($pagination && $pagination->limit()) {
            $sql .= ' LIMIT ' . intval($pagination->startFrom()) . ', ' . intval($pagination->limit());
        }

        $idList = Db()->query($sql)->fetchColumn();

        if ($pagination) {
            $pagination->setTotalItems(Db()->query('SELECT FOUND_ROWS()')->fetchValue());
        }

        $result = [];

        foreach ($idList as $id) {
            $result[] = Profile::getInstance($id);
        }

        return $result;
    }

    public static function list($params = [])
    {
        $whereClause = [];

        $whereClause[] = 'p.`del` = 0';

        $where = join(' AND ', $whereClause);

        // Обязательно добавить в список пользователя с айди
        if ($params['requiredId'] ?? false) {
            $where .= ' OR p.id = ' . intval($params['requiredId']);
        }
        unset($params['requiredId']);

        if ($params) {
            trigger_error('Unknown ' . __CLASS__ . '::' . __METHOD__ . '() params: ' . join(', ', array_keys($params)), E_USER_WARNING);
        }

        $sql = 'SELECT p.`id`, p.`name` FROM ' . Db()->quoteName(Profile::tableName()) . ' p WHERE ' . $where . ' ORDER BY p.`name`';
        $res = Db()->query($sql);

        return $res->fetchAllRows();
    }

    /**
     * @param array $params
     * @return Profile
     */
    public static function findOne($params)
    {
        $pagination = new Pagination();
        $pagination->setLimit(1);

        $list = self::findMany($params, $pagination);

        return current($list);
    }

    /**
     * @param Profile $item
     */
    public static function drop(Profile $item)
    {
        $sql = 'DELETE FROM ' . Db()->quoteName($item::tableName()) . ' WHERE `id` = ?';
        Db()->query($sql, [$item->billetId()]);
    }

    private static function buildWhere(&$params)
    {
        $where = [];

        if (isset($params['id'])) {
            $where[] = '`id` = ' . Db()->quote($params['id']);
            unset($params['id']);
        }

        if (isset($params['type'])) {
            $where[] = '`type` = ' . Db()->quote($params['type']);
            unset($params['type']);
        }

        if (isset($params['name'])) {
            $where[] = '`name` LIKE ' . Db()->quote('%' . $params['name'] . '%');
            unset($params['name']);
        }

        if (isset($params['del'])) {
            if ($params['del'] !== 'any') {
                $where[] = '`del` = ' . Db()->quote($params['del']);
            }
            unset($params['del']);
        } else {
            $where[] = '`del` = 0';
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

        $orderBy[] = '`name`, `id` DESC';

        if (empty($params['order_by'])) {
            unset($params['order_by']);
        }

        return $orderBy;
    }
}
