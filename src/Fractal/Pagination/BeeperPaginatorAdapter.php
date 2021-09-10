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

namespace Beeper\Fractal\Pagination;

use Beeper\Beeper;
use League\Fractal\Pagination\PaginatorInterface;

/**
 * A Fractal paginator adapter for Beeper
 *
 * @author Mika Tuupola <tuupola@appelsiini.net>
 */
class BeeperPaginatorAdapter implements PaginatorInterface
{
    /**
     * The paginator
     * @var Beeper
     */
    protected $paginator;

    /**
     * Setup our adapter
     */
    public function __construct(Beeper $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get current page being viewed
     */
    public function getCurrentPage(): int
    {
        return $this->paginator->page();
    }

    /**
     * Get last page
     */
    public function getLastPage(): int
    {
        return count($this->paginator);
        // return $this->paginator->getTotal();
    }

    /**
     * Get total number of items
     */
    public function getTotal(): int
    {
        return $this->paginator->total();
    }

    /**
     * Get number of pages
     */
    public function getCount(): int
    {
        return count($this->paginator);
        //return $this->paginator->count();
    }

    /**
     * Get per page
     */
    public function getPerPage(): int
    {
        return $this->paginator->size();
    }

    /**
     * Get url for the given page
     * @param  integer $page
     */
    public function getUrl($page): string
    {
        return "page={$page}";
    }
}
