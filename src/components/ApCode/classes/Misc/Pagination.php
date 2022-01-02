<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Misc;

class Pagination implements \JsonSerializable
{
    private $page  = 0;
    private $limit = 25;
    private $total = 0;

    public function totalItems()
    {
        return $this->total;
    }

    public function totalPages()
    {
        return $this->limit ? ceil($this->total / $this->limit) : -1;
    }

    public function setTotalItems($totalItems)
    {
        $this->total = intval($totalItems);
        return $this;
    }

    public function page()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = intval($page);
        return $this;
    }

    public function limit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = intval($limit);
        return $this;
    }

    public function startFrom()
    {
        return $this->page * $this->limit;
    }

    public function jsonSerialize(): array
    {
        return [
            'page'       => (int) $this->page(),
            'limit'      => (int) $this->limit(),
            'totalPages' => (int) $this->totalPages(),
            'totalItems' => (int) $this->totalItems(),
        ];
    }
}
