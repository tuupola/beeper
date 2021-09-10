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

namespace Beeper\Adapter;

use Spot\Query as SpotQuery;

/**
 * @template TSlice
 */
class SpotAdapter implements AdapterInterface
{
    /**
     * @var SpotQuery
     */
    private $query;

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
