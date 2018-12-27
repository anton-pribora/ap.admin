<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Gotcha;

interface IndexInterface
{
    function updateRecord(GotchaRecordInterface $record);
    function removeRecord(GotchaRecordInterface $record);
    function find($fields);
}