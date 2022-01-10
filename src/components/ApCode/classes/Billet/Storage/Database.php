<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Billet\Storage;

use ApCode\Billet\AbstractBillet;
use ApCode\Billet\StorageInterface;
use ApCode\Database\DatabaseInterface;
use ApCode\Misc\FileMeta\MetaManager;

class Database implements StorageInterface
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function clearCache()
    {
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Billet\StorageInterface::getRecord()
     */
    public function getRecord($class, $id)
    {
        $meta = MetaManager::classMeta($class);
        $sql  = $meta->get('sql.billet.select');

        if (empty($sql)) {
            $idField = $meta->get('db.idfield', 'id');
            $table   = $meta->get('db.table');

            $fields = [];

            foreach ($meta->get('db.map') as $prop => $field) {
                if (is_array($field)) {
                    $field = $field['field'];
                }

                $fields[] = $this->db->quoteName($field) .' AS '. $this->db->quoteName($prop);
            }

            $sql = 'SELECT '. join(', ', $fields) .' FROM '. $this->db->quoteName($table) .' WHERE '. $this->db->quoteName($idField) .' = ?';
            $meta->set('sql.billet.select', $sql);
        }

        $stm = $this->db->query($sql, [$id]);
        $values = $stm->fetchRow();

        /* @var $record AbstractBillet */
        $record = new $class;

        if ($values === false) {
            $record->setValuesFromDefaults();
        } else {
            $record->setValuesFromDb($values);
        }

        $stm->free();

        return $record;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Billet\StorageInterface::saveRecord()
     */
    public function saveRecord(\ApCode\Billet\BaseBillet $billet)
    {
        $class = get_class($billet);
        $meta  = MetaManager::classMeta($class);
        $id    = $billet->billetId();

        $table   = $billet->tableName();
        $dbmap   = $meta->get('db.map');
        $idField = $meta->get('db.idfield', 'id');
        $idProp  = $meta->get('db.idprop');

        if (empty($idProp)) {
            $idProp = array_search($idField, $dbmap);
            $meta->set('db.idprop', $idProp);
        }

        if ($id) {
            $sql = $meta->get('sql.billet.update');

            if (empty($sql)) {
                $fields = [];

                foreach ($dbmap as $prop => $field) {
                    if (is_array($field)) {
                        $field = $field['field'];
                    }

                    if ($field !== $idField) {
                        $fields[] = $this->db->quoteName($field) ." = :$prop";
                    }
                }

                $sql = 'UPDATE '. $this->db->quoteName($table) .' SET '. join(', ', $fields) .' WHERE '. $this->db->quoteName($idField) ." = :$idProp";

                $meta->set('sql.billet.update', $sql);
            }

            $billetValues = $billet->getValuesForDb();

            $stm = $this->db->query($sql, $billetValues);

            if ($stm->affected()) {
                return true;
            }
        }

        $sql = $meta->get('sql.billet.insert');

        if (empty($sql)) {
            $fields = [];
            $values = [];

            foreach ($dbmap as $prop => $field) {
                if (is_array($field)) {
                    $field = $field['field'];
                }

                $fields[] = $this->db->quoteName($field);
                $values[] = ":$prop";
            }

            $sql = 'INSERT IGNORE '. $this->db->quoteName($table) .' ('. join(', ', $fields) .') VALUES ('. join(', ', $values) .')';
            $meta->set('sql.billet.insert', $sql);
        }

        if (empty($billetValues)) {
            $billetValues = $billet->getValuesForDb();
        }

        $stm = $this->db->query($sql, $billetValues);
        $id  = $this->db->lastInsertId();

        if (empty($billet->billetId())) {
            $billet->setBilletId($id);
        }
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Billet\StorageInterface::removeRecord()
     */
    public function removeRecord(\ApCode\Billet\BaseBillet $billet)
    {
        return null;
    }
}
