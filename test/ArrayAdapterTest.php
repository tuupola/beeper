<?php

/*
 * This file is part of the Beeper package
 *
 * Copyright (c) 2014-2015 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/beeper
 *
 */

namespace Test;

use \Beeper\Adapter\ArrayAdapter;

class ArrayAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldCount()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $this->assertEquals($adapter->count(), 55);
    }

    public function testShouldSlice()
    {
        $array = range(1, 55, 1);
        $adapter = new ArrayAdapter($array);
        $this->assertEquals($adapter->slice(["offset" => 0, "limit" => 10]), range(1, 10, 1));
        $this->assertEquals($adapter->slice(["offset" => 5, "limit" => 10]), range(6, 15, 1));
    }
}
