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

namespace Beeper\Adapter;

/**
 * @template TSlice
 */
class ArrayAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    private $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function slice(array $options): array
    {
        $limit = $options["limit"];
        $offset = $options["offset"];
        return array_slice($this->collection, $offset, $limit);
    }
}
