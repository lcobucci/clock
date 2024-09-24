<?php
declare(strict_types=1);

namespace Lcobucci\Clock;

use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;

final class FrozenClock implements Clock
{
    public function __construct(private DateTimeImmutable $now)
    {
    }

    public static function fromUTC(): self
    {
        return new self(new DateTimeImmutable('now', new DateTimeZone('UTC')));
    }

    public function setTo(DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    /**
     * Adjusts the current time by a given modifier.
     *
     * @param string $modifier @see https://www.php.net/manual/en/datetime.formats.php
     *
     * @throws InvalidArgumentException When an invalid format string is passed (PHP < 8.3).
     * @throws DateMalformedStringException When an invalid date/time string is passed (PHP 8.3+).
     */
    public function adjustTime(string $modifier): void
    {
        $modifiedTime = @$this->now->modify($modifier);

        // PHP < 8.3 won't throw exceptions on invalid modifiers
        if ($modifiedTime === false) {
            throw new InvalidArgumentException('The given modifier is invalid');
        }

        $this->now = $modifiedTime;
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
