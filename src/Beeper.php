<?php

/*
 * This file is part of the Beeper package
 *
 * Copyright (c) 2014-2015 Mika Tuupola
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
    use \Witchcraft\Hydrate;

    /* Bucket holds all properties */
    private $bucket = [];

    public function __construct(array $options = [])
    {
        $defaults = [
            "page" => 1,
            "size" => 10
        ];
        $merged = array_merge($defaults, $options);
        /* Fills the bucket */
        $this->hydrate($merged);
    }

    public function get($page = null)
    {
        if (null === $page) {
            $page = $this->page;
        }
        $offset = ($page - 1) * $this->size();
        $limit = $this->size();
        return $this->adapter->slice(["offset" => $offset, "limit" => $limit]);
    }

    public function previous()
    {
        --$this->page;
        return $this;
    }

    public function getPage()
    {
        return $this->bucket["page"];
    }

    public function setPage($page)
    {
        $this->bucket["page"] = $page;
        return $this;
    }

    public function getTotal()
    {
        return $this->adapter->count();
    }

    public function getSize()
    {
        return $this->bucket["size"];
    }

    public function setSize($size)
    {
        $this->bucket["size"] = $size;
        return $this;
    }

    public function getAdapter()
    {
        return $this->bucket["adapter"];
    }

    public function setAdapter(AdapterInterface $adapter)
    {
        $this->bucket["adapter"] = $adapter;
        return $this;
    }

    /* Countable */
    public function count()
    {
        return (integer)ceil($this->total() / $this->size());
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
        return $this->page();
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
        $this->page(1);
        return $this;
    }

    /* Checks if current position is valid */
    public function valid()
    {
        return $this->page() > 0 && $this->page() <= $this->count();
    }
}
