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

namespace Test;

 use Beeper\Beeper;
 use Beeper\Adapter\NullAdapter;
 use Beeper\Adapter\ArrayAdapter;
 use PHPUnit\Framework\TestCase;

class BeeperTest extends TestCase
{

    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldProvideDefaultOptions()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->getPage(), 1);
        $this->assertEquals($beeper->getSize(), 10);
    }

    public function testShouldSetAndGetSizeUsingMutators()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->getSize(), 10);
        $beeper->setSize(5);
        $this->assertEquals($beeper->getSize(), 5);
    }

    public function testShouldSetAndGetSizeUsingMagicMethods()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->size(), 10);
        $beeper->size(5);
        $this->assertEquals($beeper->size(), 5);
    }

    public function testShouldSetAndGetSizeUsingMagicProperties()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->size, 10);
        $beeper->size = 5;
        $this->assertEquals($beeper->size, 5);
    }

    public function testShouldSetAndGetPageUsingMutators()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->getPage(), 1);
        $beeper->setPage(2);
        $this->assertEquals($beeper->getPage(), 2);
    }

    public function testShouldSetAndGetPageUsingMagicMethods()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->page(), 1);
        $beeper->page(2);
        $this->assertEquals($beeper->page(), 2);
    }

    public function testShouldSetAndGetPageUsingMagicProperties()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->page, 1);
        $beeper->page = 2;
        $this->assertEquals($beeper->page, 2);
    }

    public function testShouldSetAndGetTotalUsingMutators()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->getTotal(), 0);
        $beeper->setTotal(100);
        $this->assertEquals($beeper->getTotal(), 100);
    }

    public function testShouldSetAndGetTotalUsingMagicMethods()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->total(), 0);
        $beeper->total(100);
        $this->assertEquals($beeper->total(), 100);
    }

    public function testShouldSetAndGetTotalUsingMagicProperties()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->total, 0);
        $beeper->total = 100;
        $this->assertEquals($beeper->total, 100);
    }
    public function testShouldGetCurrentPage()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter]);
        $beeper->setPage(2);
        $this->assertEquals($beeper->get(), range(11, 20, 1));
    }

    public function testShouldGetArbitaryPage()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->get(4), range(31, 40, 1));
    }

    public function testShouldChainNext()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter]);
        $page = $beeper->next()->next()->page();
        $this->assertEquals($page, 3);
    }

    public function testShouldChainPrevious()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter, "page" => 5]);
        $page = $beeper->previous()->previous()->page();
        $this->assertEquals($page, 3);
    }

    public function testShouldRewind()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter, "page" => 5]);
        $page = $beeper->previous()->previous()->rewind()->page();
        $this->assertEquals($page, 1);
    }

    public function testShouldBeCountable()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter, "page" => 5]);
        $this->assertEquals(count($beeper), 6);
    }

    public function testShouldBeIterator()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter, "page" => 5]);
        foreach ($beeper as $key => $page) {
            $start = ($key - 1) * 10 + 1;
            /* Sixth page is half size. */
            if (6 === $key) {
                $end = $key * 10 - 5;
            } else {
                $end = $key * 10;
            }
            $this->assertEquals($page, range($start, $end, 1));
        }
    }
}
