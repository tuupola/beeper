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
    use \Witchcraft\MagicMethods;
    use \Witchcraft\MagicProperties;

    private $options;
    private $adapter;
    private $total;
    private $page; /* \Iterator already uses current() */

    public function __construct(array $options = [])
    {
        /* Default options. */
        $this->options = [
            "page" => 1,
            "size" => 10
        ];

        $this->adapter = $options["adapter"];
        unset($options["adapter"]);

        $this->options = array_merge($this->options, $options);

        $this->page = $this->options["page"];
        unset($this->options["page"]);

        $this->total = $this->adapter->count();
    }

    public function get($page = null)
    {
        if (null === $page) {
            $page = $this->page;
        }
        $offset = ($page - 1) * $this->options["size"];
        $limit = $this->options["size"];
        return $this->adapter->slice(["offset" => $offset, "limit" => $limit]);
    }

    public function previous()
    {
        --$this->page;
        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function getSize()
    {
        return $this->options["size"];
    }

    public function setSize($size)
    {
        $this->options["size"] = $size;
        return $this;
    }


    /* Countable */
    public function count()
    {
        return (integer)ceil($this->total / $this->options["size"]);
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
