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
    public function nowShouldReturnAlwaysTheSameObject(): void
    {
        $now   = new DateTimeImmutable();
        $clock = new FrozenClock($now);

        self::assertSame($now, $clock->now());
        self::assertSame($now, $clock->now());
    }

    /**
     * @test
     *
     * @covers \Lcobucci\Clock\FrozenClock::setTo
     *
     * @uses   \Lcobucci\Clock\FrozenClock::__construct()
     * @uses   \Lcobucci\Clock\FrozenClock::now
     */
    public function nowSetChangesTheObject(): void
    {
        $oldNow = new DateTimeImmutable();
        $clock  = new FrozenClock($oldNow);

        $newNow = new DateTimeImmutable();
        $clock->setTo($newNow);

        self::assertNotSame($oldNow, $clock->now());
        self::assertSame($newNow, $clock->now());
    }

    /**
     * @test
     *
     * @covers \Lcobucci\Clock\FrozenClock::fromUTC
     * @covers \Lcobucci\Clock\FrozenClock::__construct
     *
     * @uses \Lcobucci\Clock\FrozenClock::now
     */
    public function fromUTCCreatesClockFrozenAtCurrentSystemTimeInUTC(): void
    {
        $clock = FrozenClock::fromUTC();
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }
}
