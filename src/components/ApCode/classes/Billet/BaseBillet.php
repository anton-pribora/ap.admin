<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Billet;

abstract class BaseBillet
{
    /**
     * @return static
     */
    public static function getInstance($id = null)
    {
        return BilletRepository::getBilletInstance(static::class, $id);
    }

    protected function beforeSave()
    {
    }

    protected function afterSave()
    {
    }

    public function save()
    {
        $this->beforeSave();
        BilletRepository::saveBillet($this);
        $this->afterSave();
    }

    abstract public function getValuesForDb();

    abstract public function setValuesFromDb($values);

    abstract public function setValuesFromArray($values);

    abstract public static function tableName();

    abstract public function setBilletId($id);

    abstract public function billetId();
}
