<?php
declare(strict_types=1);

namespace Lcobucci\Clock;

use DateMalformedStringException;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhp;
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
    public function adjustTimeChangesTheObject(): void
    {
        $oldNow = new DateTimeImmutable();
        $newNow = $oldNow->modify('+1 day');

        $clock = new FrozenClock($oldNow);

        $clock->adjustTime('+1 day');

        self::assertNotEquals($oldNow, $clock->now());
        self::assertEquals($newNow, $clock->now());

        $clock->adjustTime('-1 day');

        self::assertEquals($oldNow, $clock->now());
        self::assertNotEquals($newNow, $clock->now());
    }

    #[Test]
    #[RequiresPhp('< 8.3.0')]
    public function adjustTimeThrowsForInvalidModifierInPhp82(): void
    {
        $clock = FrozenClock::fromUTC();

        $this->expectException(InvalidArgumentException::class);
        $clock->adjustTime('invalid');
    }

    #[Test]
    #[RequiresPhp('>= 8.3.0')]
    public function adjustTimeThrowsForInvalidModifier(): void
    {
        $clock = FrozenClock::fromUTC();

        $this->expectException(DateMalformedStringException::class);
        $clock->adjustTime('invalid');
    }

    #[Test]
    public function fromUTCCreatesClockFrozenAtCurrentSystemTimeInUTC(): void
    {
        $clock = FrozenClock::fromUTC();
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }
}
