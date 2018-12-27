<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

use ApCode\Html\Html;

class EscapedText extends UnescapedText
{
    public function __toString()
    {
        return Html::escape(parent::__toString());
    }
}