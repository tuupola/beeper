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

namespace Beeper\Adapter;

interface AdapterInterface
{
    public function count();

    public function slice(array $options);
}
