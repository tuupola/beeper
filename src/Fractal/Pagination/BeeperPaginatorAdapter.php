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
     * @var object
     */
    protected $paginator;

    /**
     * Setup our adapter
     * @param Beeper $paginator
     */
    public function __construct(Beeper $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get current page being viewed
     * @return integer
     */
    public function getCurrentPage()
    {
        return $this->paginator->getPage();
    }

    /**
     * Get last page
     * @return string
     */
    public function getLastPage()
    {
        return count($this->paginator);
        // return $this->paginator->getTotal();
    }

    /**
     * Get total number of items
     * @return integer
     */
    public function getTotal()
    {
        return $this->paginator->getTotal();
    }

    /**
     * Get number of pages
     * @return integer
     */
    public function getCount()
    {
        return count($this->paginator);
        //return $this->paginator->count();
    }

    /**
     * Get per page
     * @return integer
     */
    public function getPerPage()
    {
        return $this->paginator->getSize();
    }

    /**
     * Get url for the given page
     * @param  integer $page
     * @return string
     */
    public function getUrl($page)
    {
        return "page={$page}";
    }
}
