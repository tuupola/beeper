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
