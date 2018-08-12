<?php
declare(strict_types=1);

namespace Lcobucci\Clock;

use DateTimeImmutable;

final class FrozenClock implements Clock
{
    /**
     * @var DateTimeImmutable
     */
    private $now;

    public function __construct(DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    public function setTo(DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
