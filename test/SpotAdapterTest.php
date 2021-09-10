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

use Beeper\Adapter\SpotAdapter;
use Test\Dragon;
use PHPUnit\Framework\TestCase;

class SpotAdapterTest extends TestCase
{

    protected $spot;
    protected $mapper;

    public static function setUpBeforeClass(): void
    {
        if (class_exists("Spot\Mapper")) {
            @unlink("/tmp/test.sqlite");

            $config = new \Spot\Config();
            $config->addConnection("sqlite", [
                "path" => "/tmp/test.sqlite",
                //"memory" => true,
                "driver" => "pdo_sqlite"
            ]);
            $spot = new \Spot\Locator($config);
            $mapper = $spot->mapper("Beeper\Test\Dragon");
            $mapper->migrate();
            for ($i = 1; $i <= 55; ++$i) {
                $color = $i % 2 ? "black" : "red";
                $dragon = $mapper->create([
                    "name" => "Dragon " . $i,
                    "color" => $color
                ]);
            }
        }
    }

    public static function tearDownAfterClass(): void
    {
        @unlink("/tmp/test.sqlite");
    }

    protected function setUp(): void
    {
        if (!class_exists("Spot\Mapper")) {
            $this->markTestSkipped(
                "Run composer install vlucas/spot to run Spot tests."
            );
        } else {
            $config = new \Spot\Config();
            $config->addConnection("sqlite", [
                "path" => "/tmp/test.sqlite",
                //"memory" => true,
                "driver" => "pdo_sqlite"
            ]);
            $this->spot = new \Spot\Locator($config);
            $this->mapper = $this->spot->mapper("Beeper\Test\Dragon");
        }
    }

    public function testShouldCount()
    {
        $query = $this->mapper->all();
        $adapter = new SpotAdapter($query);
        $this->assertEquals($adapter->count(), 55);
    }

    public function testShouldSlice()
    {
        $query = $this->mapper->all();
        $adapter = new SpotAdapter($query);

        $slice = $adapter->slice(["offset" => 0, "limit" => 10]);
        $this->assertEquals($slice[0]->id, 1);
        $this->assertEquals($slice[9]->id, 10);

        $slice = $adapter->slice(["offset" => 5, "limit" => 10]);
        $this->assertEquals($slice[0]->id, 6);
        $this->assertEquals($slice[9]->id, 15);
    }

    public function testShouldCountWithGroupBy()
    {
        $query = $this->mapper->all()->group(["color"]);
        $adapter = new SpotAdapter($query);
        $this->assertEquals($adapter->count(), 2);
    }
}
