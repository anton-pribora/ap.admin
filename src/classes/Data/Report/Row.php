<?php

namespace Data\Report;

class Row
{
    private $values = [];
    private $params = [];

    public function setValue($columnKey, $value, array $params = NULL)
    {
        $this->values[ $columnKey ] = $value;

        if (!is_null($params)) {
            $this->params[$columnKey] = $params;
        }
    }

    public function increaseValue($columnKey, $amount = 1)
    {
        $this->setValue($columnKey, $this->getValue($columnKey, 0) + floatval($amount));
    }

    public function setValues($values)
    {
        $this->values = $values;
    }

    public function getValue($columnKey, $default = NULL)
    {
        return isset($this->values[$columnKey]) ? $this->values[$columnKey] : $default;
    }

    public function setParam($columnKey, $paramKey, $value)
    {
        if (!isset($this->params[$columnKey])) {
            $this->params[$columnKey] = [];
        }

        $this->params[$columnKey][$paramKey] = $value;
    }

    public function getParams($columnKey, $default = [])
    {
        if (isset($this->params[$columnKey])) {
            return $this->params[$columnKey];
        }

        return $default;
    }

    public function getParam($columnKey, $paramKey, $default = NULL)
    {
        if (isset($this->params[$columnKey][$paramKey])) {
            return $this->params[$columnKey][$paramKey];
        }

        return $default;
    }

    public function hasParam($columnKey, $paramKey)
    {
        return isset($this->params[$columnKey][$paramKey]);
    }

    public function isEmpty()
    {
        return empty($this->values);
    }
}
