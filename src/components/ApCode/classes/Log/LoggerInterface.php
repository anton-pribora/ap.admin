<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Log;

interface LoggerInterface
{
    /**
     * @return \ApCode\Log\Format 
     */
    function format();
    function log($log, $message);
    function error($message = NULL);
    function info($message = NULL);
}