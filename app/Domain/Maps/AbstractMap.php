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

    public function filter(callable $callback)
    {
        $newMap = new static();

        foreach ($this->data as $item) {
            $valid = $callback($item);

            if ($valid) {
                $newMap->add($item);
            }
        }

        return $newMap;
    }

    public function map(callable $callback)
    {
        return array_map($callback, $this->data);
    }

    public function slice(int $offset, int $length = null)
    {
        $newData = array_slice($this->data, $offset, $length);
        $newMap = new static();

        foreach ($newData as $data) {
            $newMap->add($data);
        }

        return $newMap;
    }
}
