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

use \Beeper\Adapter\NullAdapter;
use \PHPUnit\Framework\TestCase;

class NullAdapterTest extends TestCase
{

    public function testShouldCount()
    {
        $adapter = new NullAdapter();
        $this->assertEquals($adapter->count(), 0);
    }

    public function testShouldSlice()
    {
        $adapter = new NullAdapter();
        $this->assertEquals($adapter->slice(["offset" => 0, "limit" => 10]), []);
        $this->assertEquals($adapter->slice(["offset" => 5, "limit" => 10]), []);
    }
}
