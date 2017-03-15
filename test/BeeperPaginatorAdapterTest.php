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
use Beeper\Adapter\ArrayAdapter;
use Beeper\Fractal\Pagination\BeeperPaginatorAdapter;

class BeeperPaginatorAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldBeTrue()
    {
        $this->assertTrue(true);
    }

    public function testShouldCreateNewInstance()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $beeper = new Beeper(["adapter" => $adapter]);
        $paginator = new BeeperPaginatorAdapter($beeper);
        $this->assertInstanceOf(BeeperPaginatorAdapter::class, $paginator);
    }
}
