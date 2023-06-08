<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Billet;

use ApCode\Misc\FileMeta\MetaManager;

abstract class AbstractBillet extends BaseBillet
{
    protected $data = [];

    public function getValuesForDb()
    {
        $result = [];

        foreach (MetaManager::classMeta(static::class)->get('db.map') as $prop => $dbfield) {
            $default = $dbfield['default'] ?? null;

            if (isset($default) && is_callable($default)) {
                $default = $default();
            }

            if (isset($dbfield['encode'])) {
                $result[$prop] = ($dbfield['encode'])($this->data[$prop] ?? $default);
            } else {
                $result[$prop] = $this->data[$prop] ?? $default;
            }
        }

        return $result;
    }

    public function setValuesFromDefaults()
    {
        $meta = MetaManager::classMeta(static::class);

        if (!$meta->has('defaults')) {
            $defaults = [];

            foreach (MetaManager::classMeta(static::class)->get('db.map', []) as $prop => $dbfield) {
                $default = $dbfield['default'] ?? null;

                if (isset($default)) {
                    $defaults[$prop] = $default;
                    $this->data[$prop] = is_callable($default) ? $default() : $default;
                }
            }

            $meta->set('defaults', $defaults);
        } else {
            foreach ($meta->get('defaults') as $prop => $default) {
                $this->data[$prop] = is_callable($default) ? $default() : $default;
            }
        }
    }

    public function setValuesFromDb($values)
    {
        $meta = MetaManager::classMeta(static::class);

        if (!$meta->has('db.decoders')) {
            $decoders = [];

            foreach (MetaManager::classMeta(static::class)->get('db.map') as $prop => $dbfield) {
                if (isset($dbfield['decode'])) {
                    $decoders[$prop] = $dbfield['decode'];
                }
            }

            $meta->set('db.decoders', $decoders);
        }

        $this->data = $values;

        foreach ($meta->get('db.decoders') as $prop => $decoder) {
            $this->data[$prop] = $decoder($values[$prop] ?? null);
        }
    }

    public function setValuesFromArray($values)
    {
        $this->data = $values;
    }

    public static function tableName()
    {
        return MetaManager::classMeta(static::class)->get('db.table');
    }

    public function setBilletId($id)
    {
        $meta   = MetaManager::classMeta(static::class);
        $idProp = $meta->get('db.idprop');

        if (empty($idProp)) {
            $dbmap   = $meta->get('db.map');
            $idField = $meta->get('db.idfield', 'id');

            foreach ($dbmap as $prop => $field) {
                if ($field['field'] == $idField) {
                    $idProp = $prop;
                    break;
                }
            }

            $meta->set('db.idprop', $idProp);
        }

        $this->data[$idProp] = $id;
    }

    public function billetId()
    {
        $meta   = MetaManager::classMeta(static::class);
        $idProp = $meta->get('db.idprop');

        if (empty($idProp)) {
            $dbmap   = $meta->get('db.map');
            $idField = $meta->get('db.idfield', 'id');

            foreach ($dbmap as $prop => $field) {
                if ($field['field'] == $idField) {
                    $idProp = $prop;
                    break;
                }
            }

            $meta->set('db.idprop', $idProp);
        }

        return $this->data[$idProp] ?? null;
    }
}
