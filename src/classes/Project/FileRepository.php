<?php

namespace Project;

use ApCode\Misc\Pagination;

class FileRepository
{
    /**
     * @param array $params
     * @param Pagination $pagination
     * @return File[]
     */
    public static function findMany($params, Pagination $pagination = NULL)
    {
        $params = array_filter($params);

        $where   = self::buildWhere($params);
        $orderBy = self::buildOrderBy($params);

        if (!empty($params)) {
            throw new \Exception('Invalid param(s) ' . join(', ', array_keys($params)));
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS `id` FROM ' . Db()->quoteName(File::tableName());

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
            $result[] = File::getInstance($id);
        }

        return $result;
    }

    /**
     * @param array $params
     * @return File
     */
    public static function findOne($params)
    {
        $pagination = new Pagination();
        $pagination->setLimit(1);

        $list = self::findMany($params, $pagination);

        return current($list);
    }

    /**
     * @param File $item
     */
    public static function drop(File $item)
    {
        $sql = 'DELETE FROM ' . Db()->quoteName($item::tableName()) . ' WHERE `id` = ?';
        Db()->query($sql, [$item->billetId()]);

        if (is_file($item->fullPath())) {
            unlink($item->fullPath());
        }
    }

    private static function buildWhere(&$params)
    {
        $where = [];

        if (isset($params['id'])) {
            $where[] = '`id` = ' . Db()->quote($params['id']);
            unset($params['id']);
        }

        if (isset($params['parentType'])) {
            $where[] = '`parent_type` = ' . Db()->quote($params['parentType']);
            unset($params['parentType']);
        }

        if (isset($params['parentId'])) {
            $where[] = '`parent_id` = ' . Db()->quote($params['parentId']);
            unset($params['parentId']);
        }

        if (isset($params['public'])) {
            $where[] = '`public` = ' . Db()->quote($params['public']);
            unset($params['public']);
        }

        if (isset($params['guid'])) {
            $where[] = '`guid` = ' . Db()->quote($params['guid']);
            unset($params['guid']);
        }

        if (isset($params['mime'])) {
            $where[] = '`mime` = ' . Db()->quote($params['mime']);
            unset($params['mime']);
        }

        if (isset($params['name'])) {
            $where[] = '`name` LIKE ' . Db()->quote('%' . $params['name'] . '%');
            unset($params['name']);
        }

        if (isset($params['path'])) {
            $where[] = '`path` = ' . Db()->quote($params['path']);
            unset($params['path']);
        }

        if (isset($params['subFolder'])) {
            $where[] = '`path` LIKE ' . Db()->quote($params['subFolder'] . '%');
            unset($params['subFolder']);
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

        $orderBy[] = '`id` DESC';

        if (empty($params['order_by'])) {
            unset($params['order_by']);
        }

        return $orderBy;
    }
}
