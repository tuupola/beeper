<?php

/*

Copyright (c) 2014-2021 Mika Tuupola

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

/**
 * @see       https://github.com/tuupola/beeper
 * @license   https://www.opensource.org/licenses/mit-license.php
 */

namespace Beeper;

use Beeper\Adapter\AdapterInterface;

/**
 * @template TSlice
 * @implements \Iterator<int, TSlice>
 */
class Beeper implements \Iterator, \Countable
{
    /**
     * @var AdapterInterface
     */
    private $adapter;
    /**
     * @var int
     */
    private $total;
    /**
     * @var int
     */
    private $size;
    /**
     * @var int
     */
    private $page; /* \Iterator already uses current() */

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
    /**
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        return (integer)ceil($this->total / $this->size);
    }

    /* Iterator */

    /* Return the current element */
    /**
     * @return TSlice
     */
    #[\ReturnTypeWillChange]
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
    /**
     * @return self
     */
    #[\ReturnTypeWillChange]
    public function next(): self
    {
        ++$this->page;
        return $this;
    }

    /* Rewind the Iterator to the first element */
    /** @return Beeper */
    #[\ReturnTypeWillChange]
    public function rewind(): self
    {
        $this->page = 1;
        return $this;
    }

    /* Checks if current position is valid */
    /**
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return $this->page > 0 && $this->page <= $this->count();
    }
}
