<?php

declare(strict_types=1);

namespace Lcobucci\Clock;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class FrozenClockTest extends TestCase
{
    /**
     * @test
     *
     * @covers \Lcobucci\Clock\FrozenClock::__construct
     * @covers \Lcobucci\Clock\FrozenClock::now
     */
    public function nowShouldReturnAlwaysTheSameObject()
    {
        $now   = new DateTimeImmutable();
        $clock = new FrozenClock($now);

        self::assertSame($now, $clock->now());
        self::assertSame($now, $clock->now());
    }
}
