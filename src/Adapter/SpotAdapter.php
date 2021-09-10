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

use Spot\Query as SpotQuery;

/**
 * @template TSlice
 */
class SpotAdapter implements AdapterInterface
{
    private SpotQuery $query;

    public function __construct(SpotQuery $query)
    {
        $this->query = $query;
    }

    public function count(): int
    {
        /* This works also with GROUP BY queries. */
        $query = clone $this->query;
        return count($query->execute());
    }

    /**
     * @param array{"limit": int, "offset": int} $options
     */
    public function slice(array $options): SpotQuery
    {
        $limit = $options["limit"];
        $offset = $options["offset"];
        return $this->query->limit($limit, $offset);
    }
}
