<?php

declare(strict_types=1);

namespace Lcobucci\Clock;

use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

final class SystemClockTest extends TestCase
{
    /**
     * @test
     *
     * @covers \Lcobucci\Clock\SystemClock::__construct
     */
    public function constructShouldUseSystemDefaultTimezoneIfNoneWasProvided(): void
    {
        self::assertAttributeEquals(new DateTimeZone('UTC'), 'timezone', new SystemClock());
    }

    /**
     * @test
     *
     * @covers \Lcobucci\Clock\SystemClock::__construct
     * @covers \Lcobucci\Clock\SystemClock::now
     */
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
}
