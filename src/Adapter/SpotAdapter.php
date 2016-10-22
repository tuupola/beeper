<?php

/*
 * This file is part of the Beeper package
 *
 * Copyright (c) 2014-2016 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/beeper
 *
 */

namespace Beeper\Adapter;

class SpotAdapter implements AdapterInterface
{
    private $query;
    private $options;
    private $total;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function count()
    {
        /* This works also with GROUP BY queries. */
        $query = clone $this->query;
        return count($query->execute());
    }

    public function slice(array $options)
    {
        extract($options);
        return $this->query->limit($limit, $offset);
    }
}
