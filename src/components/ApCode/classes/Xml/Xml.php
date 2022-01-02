<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Xml;

class Xml
{
    static function escape($data)
    {
        return htmlentities($data, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
    
    public static function tidy($xml)
    {
        if ( !extension_loaded('tidy') )
            return $xml;

        $config = array(
            'input-xml'         => true,
            'char-encoding'     => 'utf8',
            'output-html'       => false,
            'indent'            => '1',
            'indent-spaces'     => 2,
            'tab-size'          => 2,
            'wrap-attributes'   => true,
            'wrap'              => 0,
            'indent-attributes' => true,
            'enclose-text'      => false,
            'enclose-block-text'=> false,
            'show-warnings'     => false,
            'vertical-space'    => false,
        );

        $tidy = new \tidy();

        return $tidy->repairString($xml, $config, 'UTF8') ;
    }
}