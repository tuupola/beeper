<?php

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
