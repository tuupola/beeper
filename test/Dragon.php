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

namespace Beeper\Test;

class Dragon extends \Spot\Entity
{
    protected static $table = "dragons";

    public static function fields()
    {
        return [
            "id"         => ["type" => "integer", "primary" => true, "autoincrement" => true],
            "name"       => ["type" => "string", "length" => 32, "required" => true],
            "color"      => ["type" => "string", "options" => [
                "black"  => "Black",
                "red"    => "Red"
            ]],
            "created_at" => ["type" => "datetime", "value" => new \DateTime()],
            "updated_at" => ["type" => "datetime", "value" => new \DateTime()]
        ];
    }
}
