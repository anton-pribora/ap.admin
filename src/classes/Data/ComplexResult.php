<?php

namespace Data;

class ComplexResult
{
    private $output;
    private $result;

    public function setOutput($value)
    {
        $this->output = $value;
        return $this;
    }

    public function output()
    {
        return $this->output;
    }

    public function setResult($value)
    {
        $this->result = $value;
        return $this;
    }

    public function result()
    {
        return $this->result;
    }

    public function __toString()
    {
        return $this->output;
    }
}
