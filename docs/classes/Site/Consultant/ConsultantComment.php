<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site\Consultant;

use Data\BasicData;

class ConsultantComment extends BasicData implements \JsonSerializable
{
    public function id()
    {
        return $this->data['id'] ?? null;
    }
    
    public function setId($id)
    {
        $this->data['id'] = $id;
    }
    
    public function date()
    {
        return $this->data['date'] ?? null;;
    }
    
    public function setDate($date)
    {
        $this->data['date'] = Formatter()->isoDateTime($date);
    }
    
    public function consultantId()
    {
        return $this->data['consultant'] ?? null;
    }
    
    public function setConsultantId($value)
    {
        $this->data['consultant'] = $value;
        return $this;
    }
    
    /**
     * @return \Site\Consultant
     */
    public function consultant()
    {
        return \Site\Consultant::getInstance($this->consultantId());
    }
    
    public function text()
    {
        return $this->data['text'] ?? null;
    }
    
    public function setText($text)
    {
        $this->data['text'] = $text;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [
            'id'         => $this->id(),
            'date'       => Formatter()->dateDateTime($this->date()),
            'text'       => $this->text(),
            'consultant' => [
                'id'        => $this->consultant()->id(),
                'name'      => $this->consultant()->name(),
                'thumbnail' => $this->consultant()->thumbnail('small'),
            ],
        ];
    }
}