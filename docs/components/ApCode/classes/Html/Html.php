<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html;

class Html
{
    static function escape($html, $nl2br = false)
    {
        if ( $nl2br ) {
            return nl2br(htmlentities($html, ENT_QUOTES, 'UTF-8'));
        }
        
        return htmlentities($html, ENT_QUOTES, 'UTF-8');
    }
    
    static function tidy($html)
    {
        if ( !extension_loaded('tidy') )
            return $html;

        $config = array(
            'input-xml'         => false,
            'char-encoding'     => 'utf8',
            'output-html'       => true,
            'indent'            => '1',
            'indent-spaces'     => 2,
            'tab-size'          => 2,
            'wrap-attributes'   => false,
            'wrap'              => 0,
            'indent-attributes' => false,
            'enclose-text'      => false,
            'enclose-block-text'=> false,
            'show-warnings'     => false,
            'vertical-space'    => false,
        );

        $tidy = new \tidy();

        return $tidy->repairString($html, $config, 'UTF8') ;
    }

    static function mytidy($html)
    {
        // Specify configuration
        $config = array(
            'input-xml' => true,
            'output-xml' => true,
            'indent'         => true,
            'wrap'           => 200);

        // Tidy
        $tidy = new \tidy;
        $tidy->parseString($html, $config, 'utf8');
        $tidy->cleanRepair();

        return (string) $tidy;
    }
}