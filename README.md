# Clock

[![Total Downloads](https://img.shields.io/packagist/dt/lcobucci/clock.svg?style=flat-square)](https://packagist.org/packages/lcobucci/clock)
[![Latest Stable Version](https://img.shields.io/packagist/v/lcobucci/clock.svg?style=flat-square)](https://packagist.org/packages/lcobucci/clock)

![Branch master](https://img.shields.io/badge/branch-master-brightgreen.svg?style=flat-square)
[![Build Status](https://img.shields.io/travis/lcobucci/clock/master.svg?style=flat-square)](http://travis-ci.org/#!/lcobucci/clock)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/lcobucci/clock/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/lcobucci/clock/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/lcobucci/clock/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/lcobucci/clock/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/50e3ef67-0f42-48fe-ace5-0beb9f78d117/mini.png)](https://insight.sensiolabs.com/projects/50e3ef67-0f42-48fe-ace5-0beb9f78d117)

Yet another clock abstraction...

The purpose is to decouple projects from `DateTimeImmutable` instantiation so that
we can test things properly.

## Installation

Package is available on [Packagist](http://packagist.org/packages/lcobucci/clock),
you can install it using [Composer](http://getcomposer.org).

```shell
composer require lcobucci/clock
```

## Basic usage

Simply create an make your objects dependent on the 
interface `Lcobucci\Clock\Clock` and use `SystemClock` or
`FrozenClock` to retrieve the current time:

```php
<?php

use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;
use Lcobucci\Clock\FrozenClock;

function filterData(Clock $clock, array $objects): array
{
    return array_filter(
        $objects,
        function (stdClass $object) use ($clock): bool {
            return $object->expiresAt > $clock->now();
        }
    );
}

// Object that will return the current time based on the given timezone
$clock = new SystemClock(new DateTimeZone('UTC'));

// Test object that always returns a fixed time object
$clock = new FrozenClock(
    new DateTimeImmutable('2017-05-07 18:49:30')
);

$objects = [
    (object) ['expiresAt' => new DateTimeImmutable('2017-12-31 23:59:59')],
    (object) ['expiresAt' => new DateTimeImmutable('2017-06-30 23:59:59')],
    (object) ['expiresAt' => new DateTimeImmutable('2017-01-30 23:59:59')],
];

var_dump(filterData($clock, $objects)); // last item will be filtered
```
