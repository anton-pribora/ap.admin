<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

class DateTimeManager
{
    public static function strtotime($date)
    {
        $date = preg_replace('/г\./u', '', $date);
        $date = trim($date);
        
        if (preg_match('~^\d{1,2}\s+[[:alpha:]]+\.?\s+\d{4}~u', $date)) {
            // 01 апреля 2017
            $date = preg_replace([
                '~\s+(янв)[^\s]+\s+~ui',
                '~\s+(фев)[^\s]+\s+~ui',
                '~\s+(мар)[^\s]+\s+~ui',
                '~\s+(апр)[^\s]+\s+~ui',
                '~\s+(май|мая)\s+~ui',
                '~\s+(июн)[^\s]+\s+~ui',
                '~\s+(июл)[^\s]+\s+~ui',
                '~\s+(авг)[^\s]+\s+~ui',
                '~\s+(сен)[^\s]+\s+~ui',
                '~\s+(окт)[^\s]+\s+~ui',
                '~\s+(ноя)[^\s]+\s+~ui',
                '~\s+(дек)[^\s]+\s+~ui',
            ], [
                '.01.',
                '.02.',
                '.03.',
                '.04.',
                '.05.',
                '.06.',
                '.07.',
                '.08.',
                '.09.',
                '.10.',
                '.11.',
                '.12.',
            ], $date);
        } elseif (preg_match('~^[[:alpha:]]+\s+\d{4}~u', $date)) {
            // апреля 2017
            $date = preg_replace([
                '~^(янв)[^\s]+\s+~ui',
                '~^(фев)[^\s]+\s+~ui',
                '~^(мар)[^\s]+\s+~ui',
                '~^(апр)[^\s]+\s+~ui',
                '~^(май|мая)\s+~ui',
                '~^(июн)[^\s]+\s+~ui',
                '~^(июл)[^\s]+\s+~ui',
                '~^(авг)[^\s]+\s+~ui',
                '~^(сен)[^\s]+\s+~ui',
                '~^(окт)[^\s]+\s+~ui',
                '~^(ноя)[^\s]+\s+~ui',
                '~^(дек)[^\s]+\s+~ui',
            ], [
                '01.01.',
                '01.02.',
                '01.03.',
                '01.04.',
                '01.05.',
                '01.06.',
                '01.07.',
                '01.08.',
                '01.09.',
                '01.10.',
                '01.11.',
                '01.12.',
            ], $date);
        } elseif (preg_match('~^\d{1,2}\s+[[:alpha:]]+$~u', $date)) {
            // 1 апреля
            $date = preg_replace([
                '~\s+(янв)[^\s]+\s+~ui',
                '~\s+(фев)[^\s]+\s+~ui',
                '~\s+(мар)[^\s]+\s+~ui',
                '~\s+(апр)[^\s]+\s+~ui',
                '~\s+(май|мая)\s+~ui',
                '~\s+(июн)[^\s]+\s+~ui',
                '~\s+(июл)[^\s]+\s+~ui',
                '~\s+(авг)[^\s]+\s+~ui',
                '~\s+(сен)[^\s]+\s+~ui',
                '~\s+(окт)[^\s]+\s+~ui',
                '~\s+(ноя)[^\s]+\s+~ui',
                '~\s+(дек)[^\s]+\s+~ui',
            ], [
                '.01.',
                '.02.',
                '.03.',
                '.04.',
                '.05.',
                '.06.',
                '.07.',
                '.08.',
                '.09.',
                '.10.',
                '.11.',
                '.12.',
            ], "$date ". date('Y'));
        } elseif (preg_match('~^(\d{1,2})\D(\d{4})$~', $date, $matches)) {
            $date = "01.{$matches[1]}.{$matches[2]}";
        }
        
        return is_numeric($date) ? $date : strtotime($date);
    }
    
    static function format($format, $time = 'now')
    {
        return date($format, is_int($time) ? $time : self::strtotime($time));
    }
    
    static function strftime($format, $time = 'now')
    {
        return strftime($format, is_int($time) ? $time : self::strtotime($time));
    }
    
    static function isodate($time = 'now')
    {
        return self::format('Y-m-d', $time);
    }
    
    static function isodatetime($time = 'now')
    {
        return self::format('Y-m-d H:i:s', $time);
    }
    
    static function dayOfWeekName($time = 'now')
    {
        return self::strftime('%A', $time);
    }
    
    static function monthName($time = 'now')
    {
        return self::strftime('%B', $time);
    }
}