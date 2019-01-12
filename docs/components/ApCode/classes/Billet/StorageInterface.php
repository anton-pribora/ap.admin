<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Billet;

interface StorageInterface
{
    function clearCache();
    function getRecord($class, $id);
    function saveRecord(BaseBillet $billet);
    function removeRecord(BaseBillet $billet);
}