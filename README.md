# Beeper

Generic pages for PHP 5.4+

[![Author](http://img.shields.io/badge/author-@tuupola-blue.svg?style=flat-square)](https://twitter.com/tuupola)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Build Status](https://img.shields.io/travis/tuupola/beeper/master.svg?style=flat-square)](https://travis-ci.org/tuupola/beeper)
[![HHVM Status](https://img.shields.io/hhvm/tuupola/beeper.svg?style=flat-square)](http://hhvm.h4cc.de/package/tuupola/beeper)
[![Coverage](http://img.shields.io/codecov/c/github/tuupola/beeper.svg?style=flat-square)](https://codecov.io/github/tuupola/beeper)

## Install

You can install latest version using [composer](https://getcomposer.org/).

```
$ composer require tuupola/beeper
```

## Usage

```php
use Beeper\Adapter\ArrayAdapter;
use Beeper\Beeper;

$array = range(1, 12, 1);
$adapter = new ArrayAdapter($array);

$beeper = new Beeper(["adapter" => $adapter, "size" => 5, "page" => 1]);

foreach ($beeper as $key => $page) {
    print_r($page);
}
```

```
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] => 4
    [4] => 5
)
Array
(
    [0] => 6
    [1] => 7
    [2] => 8
    [3] => 9
    [4] => 10
)
Array
(
    [0] => 11
    [1] => 12
)
```

```php
$beeper
    ->rewind()
    ->next()
    ->next();

print_r($beeper->get());
```

```
Array
(
    [0] => 11
    [1] => 12
)
```