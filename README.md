# Clock

[![Total Downloads]](https://packagist.org/packages/lcobucci/clock)
[![Latest Stable Version]](https://packagist.org/packages/lcobucci/clock)
[![Unstable Version]](https://packagist.org/packages/lcobucci/clock)

[![Build Status]](https://github.com/lcobucci/clock/actions?query=workflow%3A%22PHPUnit%20Tests%22+branch%3A2.1.x)
[![Code Coverage]](https://codecov.io/gh/lcobucci/clock)

Yet another clock abstraction...

The purpose is to decouple projects from `DateTimeImmutable` instantiation so that we can test things properly.

## Installation

Package is available on [Packagist], you can install it using [Composer].

```shell
composer require lcobucci/clock
```

## Usage

Make your objects depend on the `Lcobucci\Clock\Clock` interface and use `SystemClock` or `FrozenClock` to retrieve the current time or a specific time (for testing), respectively:

```php
<?php

use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;
use Lcobucci\Clock\FrozenClock;

function filterData(Clock $clock, array $objects): array
{
    return array_filter(
        $objects,
        static function (stdClass $object) use ($clock): bool {
            return $object->expiresAt > $clock->now();
        }
    );
}

// Object that will return the current time based on the given timezone
// $clock = SystemClock::fromSystemTimezone();
// $clock = SystemClock::fromUTC();
$clock = new SystemClock(new DateTimeZone('America/Sao_Paulo'));

// Test object that always returns a fixed time object
$clock = new FrozenClock(
    new DateTimeImmutable('2017-05-07 18:49:30')
);

// Or creating a frozen clock from the current time on UTC
// $clock = FrozenClock::fromUTC();

$objects = [
    (object) ['expiresAt' => new DateTimeImmutable('2017-12-31 23:59:59')],
    (object) ['expiresAt' => new DateTimeImmutable('2017-06-30 23:59:59')],
    (object) ['expiresAt' => new DateTimeImmutable('2017-01-30 23:59:59')],
];

var_dump(filterData($clock, $objects)); // last item will be filtered
```

[Total Downloads]: https://img.shields.io/packagist/dt/lcobucci/clock.svg?style=flat-square
[Latest Stable Version]: https://img.shields.io/packagist/v/lcobucci/clock.svg?style=flat-square
[Unstable Version]: https://img.shields.io/packagist/vpre/lcobucci/clock.svg?style=flat-square
[Build Status]: https://img.shields.io/github/workflow/status/lcobucci/clock/PHPUnit%20tests/2.1.x?style=flat-square
[Code Coverage]: https://codecov.io/gh/lcobucci/clock/branch/2.1.x/graph/badge.svg
[Packagist]: http://packagist.org/packages/lcobucci/clock
[Composer]: http://getcomposer.org
