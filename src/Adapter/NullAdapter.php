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
class NullAdapter implements AdapterInterface
{

    private array $collection;

    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    public function count(): int
    {
        return 0;
    }

    public function slice(array $options): array
    {
        return [];
    }
}
