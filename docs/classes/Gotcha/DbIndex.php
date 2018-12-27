<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Gotcha;

use ApCode\Database\DatabaseInterface;

class DbIndex implements IndexInterface, OptionsInterface
{
    private $indexTable   = 'gotcha_index';
    private $fieldsTable  = 'gotcha_fields';
    private $typesTable   = 'gotcha_types';
    private $optionsTable = 'gotcha_options';

    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritDoc}
     * @see \Gotcha\IndexIterface::updateRecord()
     */
    public function updateRecord(GotchaRecordInterface $record)
    {
        if (!$record->id()) {
            return ;
        }
        
        $this->removeRecord($record);

        $values = [];

        foreach ($record->gotchaFields() as $row) {
            list($fieldKey, $value, $param1) = $row + ['', '', ''];
            $values[] = sprintf('(%s, %s, %s, %s, %s)',
                $record->id(),
                $this->typeId($record->gotchaType()),
                $this->fieldId($fieldKey),
                $this->db->quote($value),
                $this->db->quote($param1)
            );
        }

        if ($values) {
            $sql = 'INSERT INTO "'. $this->indexTable .'" ("record_id", "record_type_id", "field_id", "field_value", "param1") VALUES '. join(',', $values);
            $this->db->query($sql);
        }
    }

    /**
     * {@inheritDoc}
     * @see \Gotcha\IndexIterface::removeRecord()
     */
    public function removeRecord(GotchaRecordInterface $record)
    {
        $this->db->query('DELETE FROM "'. $this->indexTable .'" WHERE "record_id" = ? AND "record_type_id" = ?', [$record->id(), $this->typeId($record->gotchaType())]);
    }

    private function typeId($type)
    {
        static $types = [];

        if (isset($types[$type])) {
            return $types[$type];
        }

        $id = $this->db->query('SELECT "id" FROM "'. $this->typesTable .'" WHERE "name" = ?', [$type])->fetchValue();

        if (empty($id)) {
            $sql = 'INSERT INTO "'. $this->typesTable .'" ("name") VALUES ('. $this->db->quote($type) .')';
            $res = $this->db->query($sql);

            $id = $this->db->lastInsertId();
        }

        $types[$type] = $id;

        return $id;
    }
    
    public function makeSearchField($field, $value, $compare = NULL, $logic = NULL)
    {
        return new SearchField($field, $value, $compare, $logic);
    }

    /**
     * {@inheritDoc}
     * @see \Gotcha\IndexIterface::find()
     */
    public function find($fields)
    {
        $whereClause = [];

        foreach ($fields as $field) {
            if (is_array($field)) {
                $field = $this->makeSearchField(...$field);
            }
            
            [$recordType, $fieldKey] = explode('.', $field->field(), 2) + [null, null];
            
            $whereClause[] = sprintf('("record_type_id" = %s AND "field_id" = %s AND %s)',
                $this->typeId($recordType),
                $this->fieldId($fieldKey),
                $field->getSqlCondition()
            );
        }

        $sql = 'SELECT "record_id", COUNT("record_id") FROM "'. $this->indexTable .'" WHERE '. join(' OR ', $whereClause) .' GROUP BY "record_id" HAVING COUNT("record_id") >= '. count($fields);
        return $this->db->query($sql)->fetchColumn();
    }

    private function fieldId($field)
    {
        static $fields = [];

        if (isset($fields[$field])) {
            return $fields[$field];
        }

        $id = $this->db->query('SELECT "id" FROM "'. $this->fieldsTable .'" WHERE "name" = ?', [$field])->fetchValue();

        if (empty($id)) {
            $sql = 'INSERT INTO "'. $this->fieldsTable .'" ("name") VALUES ('. $this->db->quote($field) .')';
            $res = $this->db->query($sql);

            $id = $this->db->lastInsertId();
        }

        $fields[$field] = $id;

        return $id;
    }
    /**
     * {@inheritDoc}
     * @see \Gotcha\OptionsInterface::getOption()
     */
    public function getOption($name, $default = NULL)
    {
        $res = $this->db->query('SELECT "value" FROM "'. $this->optionsTable .'" WHERE "name" = ?', [$name]);

        if ($res->affected()) {
            return $res->fetchValue();
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     * @see \Gotcha\OptionsInterface::setOption()
     */
    public function setOption($name, $value)
    {
        if (is_null($this->getOption($name))) {
            $this->db->query('INSERT "'. $this->optionsTable .'" ("value", "name") VALUES (?, ?)', [$value, $name]);
        } else {
            $this->db->query('UPDATE "'. $this->optionsTable .'" SET "value" = ? WHERE "name" = ?', [$value, $name]);
        }
    }
}