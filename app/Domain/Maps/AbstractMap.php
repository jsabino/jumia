<?php

namespace App\Domain\Maps;

use Countable;
use Iterator;

abstract class AbstractMap implements Iterator, Countable
{

    protected $data = [];

    public function current()
    {
        return current($this->data);
    }

    public function next()
    {
        next($this->data);
    }

    public function key()
    {
        return key($this->data);
    }

    public function valid()
    {
        $key = $this->key();
        return $key !== null && $key !== false;
    }

    public function rewind()
    {
        reset($this->data);
    }

    public function count()
    {
        return count($this->data);
    }
}
