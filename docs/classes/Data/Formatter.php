<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

class Formatter
{
    private $timezone = 'GMT+05:00';
    private $locale = 'en_EN';
    
    function dateMonthYear($date)
    {
        $time = DateTimeManager::strtotime($date);
        return $time ? DateTimeManager::strftime('%B %Y', $date) : $date;
    }
    
    function dateDayMonth($date)
    {
        static $fmt = null;
        
        if (empty($fmt)) {
            $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
            $fmt->setTimeZone($this->timezone);
            $fmt->setPattern('d MMMM');
        }
        
        $time = DateTimeManager::strtotime($date);
        return $time ? $fmt->format($time) : $date;
    }
    
    function dateDayMonthYear($date)
    {
        static $fmt = null;
        
        if (empty($fmt)) {
            $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
            $fmt->setTimeZone($this->timezone);
        }
        
        $time = DateTimeManager::strtotime($date);
        return $time ? $fmt->format($time) : $date;
    }
    
    function dateDayMonthYearShort($date)
    {
        static $fmt = null;
        
        if (empty($fmt)) {
            $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::SHORT, \IntlDateFormatter::NONE);
            $fmt->setTimeZone($this->timezone);
            $fmt->setPattern('d MMM yy');
        }
        
        $time = DateTimeManager::strtotime($date);
        return $time ? $fmt->format($time) : $date;
    }
    
    function dateDayMonthYear3($date)
    {
        $time = DateTimeManager::strtotime($date);
        return $time ? DateTimeManager::strftime('%d.%m.%Y', $date) : $date;
    }
    
    function isoDate($date)
    {
        $time = DateTimeManager::strtotime($date);
        return $time ? date('Y-m-d', $time) : date('Y-m-d');
    }
    
    function isoDateTime($date)
    {
        $time = DateTimeManager::strtotime($date);
        return $time ? date('Y-m-d H:i:s', $time) : date('Y-m-d');
    }
    
    function dateDateTime($date)
    {
        static $fmt = null;
        
        if (empty($fmt)) {
            $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT);
            $fmt->setTimeZone($this->timezone);
        }
        
        $time = DateTimeManager::strtotime($date);
        return $time ? $fmt->format($time) : $date;
    }
    
    function money($value, $currency = 'RUR')
    {
        static $fmt;
        
        if (empty($fmt)) {
            $fmt = new \NumberFormatter($this->locale, \NumberFormatter::CURRENCY);
            $fmt->setTextAttribute(\NumberFormatter::CURRENCY_CODE, 'RUR');
        }
        
        if (fmod($value, 1)) {
            $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
        } else {
            $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
        }
        
        return $fmt->formatCurrency($value, $currency);
    }
    
    function integer($value)
    {
        static $fmt;
        
        if (empty($fmt)) {
            $fmt = new \NumberFormatter($this->locale, \NumberFormatter::DECIMAL);
        }
        
        return $fmt->format($value);
    }
    
    
    function pluralNum($number, $words)
    {
        $num = $number % 100;
        
        if ($num > 19) {
            $num = $num % 10;
        }
        
        switch ($num) {
            case 1: {
                $word = $words[0];
                break;
            }
            case 2: case 3: case 4: {
                $word = $words[1];
                break;
            }
            default: {
                $word = $words[2];
                break;
            }
        }
        
        return $number .' '. $word;
    }
    
    function years($years)
    {
        return $this->pluralNum($years, ['год', 'года', 'лет']);
    }
    
    function months($months)
    {
        $result = '';
        $years  = intval($months / 12);
        $months = $months % 12;
        
        if ($years) {
            $result .= $this->years($years) .' ';
        }
        
        if ($months) {
            if ($result) {
                $result .= 'и ';
            }
            
            $result .= $this->pluralNum($months, ['месяц', 'месяца', 'месяцев']);
        }
        
        return $result ?: '0 месяцев';
    }
}