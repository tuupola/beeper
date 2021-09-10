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

/**
 * @template TSlice
 * @implements \Iterator<int, TSlice>
 */
class Beeper implements \Iterator, \Countable
{
    private AdapterInterface $adapter;
    private int $total;
    private int $size;
    private int $page; /* \Iterator already uses current() */

    /**
     * @param array{"adapter": AdapterInterface, "page": int, "size": int} $options
    */
    public function __construct(array $options)
    {
        $this->adapter = $options["adapter"];
        $this->page = $options["page"] ?? 1;
        $this->size = $options["size"] ?? 10;
        $this->total = $this->adapter->count();
    }

    /**
     * @return TSlice
     */
    public function get(int $page = null)
    {
        if (null === $page) {
            $page = $this->page;
        }
        $offset = ($page - 1) * $this->size;
        $limit = $this->size;
        return $this->adapter->slice(["offset" => $offset, "limit" => $limit]);
    }

    public function previous(): int
    {
        return --$this->page;
    }

    public function page(int $page = null): int
    {
        if (null !== $page) {
            $this->page = $page;
        }
        return $this->page;
    }

    public function total(int $total = null): int
    {
        if (null !== $total) {
            $this->total = $total;
        }
        return $this->total;
    }

    public function size(int $size = null): int
    {
        if (null !== $size) {
            $this->size = $size;
        }
        return $this->size;
    }

    /* Countable */
    public function count()
    {
        return (integer)ceil($this->total / $this->size);
    }

    /* Iterator */

    /* Return the current element */
    /**
     * @return TSlice
     */
    public function current()
    {
        return $this->get();
    }

    /* Return the key of the current element */
    public function key(): int
    {
        return $this->page;
    }

    /* Move forward to next element */
    public function next(): self
    {
        ++$this->page;
        return $this;
    }

    /* Rewind the Iterator to the first element */
    /** @return Beeper */
    public function rewind(): self
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
