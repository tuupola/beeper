# Beeper

Generic pager for PHP 7.1+

[![Latest Version](https://img.shields.io/packagist/v/tuupola/beeper.svg?style=flat-square)](https://packagist.org/packages/tuupola/beeper)
[![Packagist](https://img.shields.io/packagist/dm/tuupola/beeper.svg)](https://packagist.org/packages/tuupola/beeper)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/workflow/status/tuupola/beeper/Tests/master?style=flat-square)](https://github.com/tuupola/beeper/actions)
[![Coverage](https://img.shields.io/codecov/c/github/tuupola/beeper.svg?style=flat-square)](https://codecov.io/github/tuupola/beeper)

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
$beeper->rewind();
$beeper->next();
$beeper->next();

print_r($beeper->get());
```

```
Array
(
    [0] => 11
    [1] => 12
)
```
