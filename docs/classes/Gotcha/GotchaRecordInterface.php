<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Gotcha;

interface GotchaRecordInterface
{
    function id();
    function gotchaType();
    function gotchaFields();
}