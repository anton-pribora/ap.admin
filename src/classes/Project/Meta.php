<?php

namespace Project;

trait Meta
{
    public function meta($path, $default = null)
    {
        $key = strtr($path, ['.' => "']['"]);
        return eval("return \$this->data['meta']['{$key}'] ?? \$default;");
    }

    public function rawMeta()
    {
        return $this->data['meta'] ?? [];
    }

    public function setMeta($path, $value)
    {
        $key = strtr($path, ['.' => "']['"]);

        if (isset($value)) {
            eval("\$this->data['meta']['{$key}'] = \$value;");
        } else {
            eval("unset(\$this->data['meta']['{$key}']);");
        }

        return $this;
    }
}
