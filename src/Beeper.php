<?php

/*
 * This file is part of the Beeper package
 *
 * Copyright (c) 2014-2017 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/beeper
 *
 */

namespace Beeper;

use Beeper\Adapter\AdapterInterface;

class Beeper implements \Iterator, \Countable
{
    private $options;
    private $adapter;
    private $total;
    private $size;
    private $page; /* \Iterator already uses current() */

    public function __construct(array $options = [])
    {
        $this->adapter = $options["adapter"];
        $this->page = $options["page"] ?? 1;
        $this->size = $options["size"] ?? 10;
        $this->total = $this->adapter->count();
    }

    public function get($page = null)
    {
        if (null === $page) {
            $page = $this->page;
        }
        $offset = ($page - 1) * $this->size;
        $limit = $this->size;
        return $this->adapter->slice(["offset" => $offset, "limit" => $limit]);
    }

    public function previous()
    {
        --$this->page;
        return $this;
    }

    public function page($page = null)
    {
        if (null === $page) {
            return $this->page;
        }
        $this->page = $page;
        return $this;
    }

    public function total($total = null)
    {
        if (null === $total) {
            return $this->total;
        }
        $this->total = $total;
        return $this;
    }

    public function size($size = null)
    {
        if (null === $size) {
            return $this->size;
        }
        $this->size = $size;
        return $this;
    }

    /* Countable */
    public function count()
    {
        return (integer)ceil($this->total / $this->size);
    }

    /* Iterator */

    /* Return the current element */
    public function current()
    {
        return $this->get();
    }

    /* Return the key of the current element */
    public function key()
    {
        return $this->page;
    }

    /* Move forward to next element */
    public function next()
    {
        ++$this->page;
        return $this;
    }

    /* Rewind the Iterator to the first element */
    public function rewind()
    {
        $this->page = 1;
        return $this;
    }

    /* Checks if current position is valid */
    public function valid()
    {
        return $this->page > 0 && $this->page <= $this->count();
    }
}
