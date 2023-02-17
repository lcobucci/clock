<?php
declare(strict_types=1);

namespace Lcobucci\Clock;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(FrozenClock::class)]
final class FrozenClockTest extends TestCase
{
    #[Test]
    public function nowShouldReturnAlwaysTheSameObject(): void
    {
        $now   = new DateTimeImmutable();
        $clock = new FrozenClock($now);

        self::assertSame($now, $clock->now());
        self::assertSame($now, $clock->now());
    }

    #[Test]
    public function nowSetChangesTheObject(): void
    {
        $oldNow = new DateTimeImmutable();
        $clock  = new FrozenClock($oldNow);

        $newNow = new DateTimeImmutable();
        $clock->setTo($newNow);

        self::assertNotSame($oldNow, $clock->now());
        self::assertSame($newNow, $clock->now());
    }

    #[Test]
    public function fromUTCCreatesClockFrozenAtCurrentSystemTimeInUTC(): void
    {
        $clock = FrozenClock::fromUTC();
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }
}
