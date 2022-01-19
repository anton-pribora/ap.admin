<?php

class Halter
{
    const NONE   = 0;
    const INIT   = 1;
    const ACTION = 2;
    const RENDER = 3;
    const ALL    = 99;

    private $level = self::NONE;

    private function level($bool, $level)
    {
        if (is_null($bool)) {
            return $this->level >= $level;
        }

        if ($this->level < $level) {
            $this->level = $level;
        }
    }

    public function init($bool = NULL)
    {
        return $this->level($bool, self::INIT);
    }

    public function action($bool = NULL)
    {
        return $this->level($bool, self::ACTION);
    }

    public function render($bool = NULL)
    {
        return $this->level($bool, self::RENDER);
    }

    public function all($bool = NULL)
    {
        return $this->level($bool, self::ALL);
    }

    public function none($bool = NULL)
    {
        if (is_null($bool)) {
            return $this->level == self::NONE;
        }

        $this->level = self::NONE;
    }
}
