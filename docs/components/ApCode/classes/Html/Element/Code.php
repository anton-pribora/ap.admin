<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

use ApCode\Html\Html;

class Code extends ContentableElement
{
    protected $tagName = 'code';
    
    public function __construct($contents = null, $nl2br = null)
    {
        if ( $nl2br && is_string($contents) ) {
            $contents = new UnescapedText(nl2br(Html::escape($contents), true));
        }
        
        parent::__construct($contents);
    }
}
