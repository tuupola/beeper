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

class ArrayAdapter implements AdapterInterface
{
    private $collection;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function count()
    {
        return count($this->collection);
    }

    public function slice(array $options)
    {
        extract($options);
        return array_slice($this->collection, $offset, $limit);
    }
}
