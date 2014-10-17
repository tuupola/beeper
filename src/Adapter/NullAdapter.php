<?php

/*
 * This file is part of the Beeper package
 *
 * Copyright (c) 2014 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/beeper
 *
 */

namespace Beeper\Adapter;

class NullAdapter implements AdapterInterface
{
    private $collection;

    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    public function count()
    {
        return 0;
    }

    public function slice(array $options)
    {
        return [];
    }
}
