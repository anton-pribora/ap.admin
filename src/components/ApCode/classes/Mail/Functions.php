<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail;

class Functions
{
    /**
     * Преобразование списка адресов
     *
     * @param $mails string
     * @return array
     */
    static public function mail2array($mails)
    {
        $result = array();
        
        if ( is_array($mails) ) {
            foreach ($mails as $mail) {
                $array = self::mail2array($mail);
                
                if ($array) {
                    $result = array_merge($result, $array);
                }
            }
        } else {
            $mails = preg_replace([
                '/\s*@\s*/',
                '/\r?\n/',
                '/\\.(\\W|$)/u',
                '/[<>]/',
            ], [
                '@',
                ', ',
                ',\\1',
                ''
            ], $mails);
            
            foreach (preg_split('~[ ,;:/]+~', $mails) as $mail) {
                $mail = trim($mail);
                
                if ( !$mail ) {
                    continue;
                }
                
                // Нормализуем адреса, заменяем русские буквы на латинские
                $mail = strtr($mail, [
                    'с' => 'c',
                    'а' => 'a',
                    'о' => 'o',
                    'е' => 'e',
                    'р' => 'p'
                ]);
                
                if (self::isValidEmail($mail)) {
                    $result[] = $mail;
                }
            }
        }
        
        return array_unique($result);
    }

    /**
     * Проверка почтового адреса на валидность
     *
     * @param string $address
     * @return bool
     */
    static public function isValidEmail($address)
    {
        return (bool) preg_match('/^[\w+\._-]+@[\w+\._-]+$/iu', $address);
    }
}