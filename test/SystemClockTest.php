<?php
declare(strict_types=1);

namespace Lcobucci\Clock;

use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function date_default_timezone_get;

#[CoversClass(SystemClock::class)]
final class SystemClockTest extends TestCase
{
    #[Test]
    public function nowShouldRespectTheProvidedTimezone(): void
    {
        $timezone = new DateTimeZone('America/Sao_Paulo');
        $clock    = new SystemClock($timezone);

        $lower = new DateTimeImmutable('now', $timezone);
        $now   = $clock->now();
        $upper = new DateTimeImmutable('now', $timezone);

        self::assertEquals($timezone, $now->getTimezone());
        self::assertGreaterThanOrEqual($lower, $now);
        self::assertLessThanOrEqual($upper, $now);
    }

    #[Test]
    public function fromUTCCreatesAnInstanceUsingUTCAsTimezone(): void
    {
        $clock = SystemClock::fromUTC();
        $now   = $clock->now();

        self::assertSame('UTC', $now->getTimezone()->getName());
    }

    #[Test]
    public function fromSystemTimezoneCreatesAnInstanceUsingTheDefaultTimezoneInSystem(): void
    {
        $clock = SystemClock::fromSystemTimezone();
        $now   = $clock->now();

        self::assertSame(date_default_timezone_get(), $now->getTimezone()->getName());
    }
}
