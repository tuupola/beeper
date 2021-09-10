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
        $this->assertEquals($beeper->page(), 1);
        $this->assertEquals($beeper->size(), 10);
    }

    public function testShouldSetAndGetSizeUsingMagicMethods()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->size(), 10);
        $beeper->size(5);
        $this->assertEquals($beeper->size(), 5);
    }

    public function testShouldSetAndGetPageUsingMagicMethods()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->page(), 1);
        $beeper->page(2);
        $this->assertEquals($beeper->page(), 2);
    }

    public function testShouldSetAndGetTotalUsingMagicMethods()
    {
        $adapter = new NullAdapter();
        $beeper = new Beeper(["adapter" => $adapter]);
        $this->assertEquals($beeper->total(), 0);
        $beeper->total(100);
        $this->assertEquals($beeper->total(), 100);
    }

    public function testShouldGetCurrentPage()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter]);
        $beeper->page(2);
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
        $beeper->previous();
        $beeper->previous();
        $page = $beeper->page();
        $this->assertEquals($page, 3);
    }

    public function testShouldRewind()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter, "page" => 5]);
        $beeper->previous();
        $beeper->previous();
        $beeper->rewind();
        $page = $beeper->page();
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
