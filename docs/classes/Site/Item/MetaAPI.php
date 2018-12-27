<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site\Item;

class MetaAPI
{
    private $item;
    private $metaValue = [];
    private $loadedMeta = [];
    private $loadedAll;

    public function __construct(\Site\Item $item)
    {
        $this->item = $item;
    }

    private function loadMeta($key)
    {
        [$key] = explode('.', $key, 2);
        
        if (isset($this->loadedMeta[$key])) {
            return;
        }
        
        $sql = 'SELECT "id", "value" FROM "site_item_meta" WHERE "item_id" = ? AND "name" = ? LIMIT 1';
        $res = Db()->query($sql, [$this->item->id(), $key]);
        
        if ($res->affected()) {
            $row = $res->fetchRow();
            
            $this->metaValue[$key] = json_decode_array(gzinflate($row['value']));
            $this->loadedMeta[$key] = $row['id'];
        } else {
            $this->loadedMeta[$key] = null;
        }
    }

    private function loadAll()
    {
        $sql = 'SELECT "id", "name", "value" FROM "site_item_meta" WHERE "item_id" = ?';
        $res = Db()->query($sql, [$this->item->id()]);
        
        foreach ($res->fetchAllRows() as $row) {
            $this->loadedMeta[$row['name']] = $row['id'];
            $this->metaValue[$row['name']] = json_decode_array(gzinflate($row['value']));
        }
    }

    private function saveMeta($key)
    {
        [$key] = explode('.', $key, 2);
        
        if (!array_key_exists($key, $this->metaValue)) {
            return;
        }
        
        $value = $this->metaValue[$key];
        
        if ($value === null) {
            if ($this->loadedMeta[$key] ?? null) {
                $sql = 'DELETE FROM "site_item_meta" WHERE "id" = ?';
                Db()->query($sql, [$this->loadedMeta[$key]]);
            }
        } else {
            $data = gzdeflate(json_encode_array($value));
            
            if ($this->loadedMeta[$key] ?? null) {
                $sql = 'UPDATE "site_item_meta" SET "value" = ? WHERE "id" = ?';
                Db()->query($sql, [$data, $this->loadedMeta[$key]]);
            } else {
                $sql = 'INSERT INTO "site_item_meta" ("item_id", "name", "value") VALUES (?, ?, ?)';
                Db()->query($sql, [$this->item->id(), $key, $data]);
                
                $this->loadedMeta[$key] = Db()->lastInsertId();
            }
        }
    }

    private function saveAll()
    {
        foreach (array_keys($this->metaValue) as $key) {
            $this->saveMeta($key);
        }
    }

    public function set($key, $value)
    {
        $this->loadMeta($key);
        
        $key = "'" . strtr($key, ['.' => "']['"]) . "'";
        
        eval('$this->metaValue[' . $key . '] = $value;');
        
        return $this;
    }

    public function get($key, $default = NULL)
    {
        $this->loadMeta($key);
        
        $key = "'" . strtr($key, ['.' => "']['"]) . "'";
        
        return eval('return $this->metaValue[' . $key . '] ?? $default;');
    }

    public function &getLink($key, $default = [])
    {
        $this->loadMeta($key);
        
        $key = "'" . strtr($key, ['.' => "']['"]) . "'";
        
        $result = null;
        
eval(<<<PHP
        if (!isset(\$this->metaValue[$key])) {
            \$this->metaValue[$key] = \$default;
        }

        \$result = &\$this->metaValue[$key];
PHP
);
        return $result;
    }

    public function getAll()
    {
        if (!$this->loadedAll) {
            $this->loadAll();
            $this->loadedAll = true;
        }
        
        return $this->metaValue;
    }

    public function save($key = NULL)
    {
        if (empty($key)) {
            $this->saveAll();
        } else {
            $this->saveMeta($key);
        }
        
        return $this;
    }

    public function __debugInfo()
    {
        return $this->metaValue;
    }
}