<?php

declare(strict_types=1);

namespace Lcobucci\Clock;

use DateTimeZone;
use DateTimeImmutable;
use function date_default_timezone_get;

final class SystemClock implements Clock
{
    private $timezone;

    public function __construct(DateTimeZone $timezone)
    {
        $this->timezone = $timezone;
    }

    public static function fromUTC(): self
    {
        return new self(new DateTimeZone('UTC'));
    }

    public static function fromSystemTimezone(): self
    {
        return new self(new DateTimeZone(date_default_timezone_get()));
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timezone);
    }
}
