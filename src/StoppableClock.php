<?php

namespace Lcobucci\Clock;

use DateTimeImmutable;

class StoppableClock implements Clock
{
	private Clock $clock;
	private ?DateTimeImmutable $pausedAt;

	public function __construct(Clock $clock, ?DateTimeImmutable $pausedAt = null)
	{
		$this->clock = $clock;
		$this->pausedAt = $pausedAt;
	}

	public function pause(): void
	{
		$this->pausedAt = $this->clock->now();
	}

	public function resume(): void
	{
		$this->pausedAt = null;
	}

	public function isPaused(): bool
	{
		return $this->pausedAt !== null;
	}

	public function now(): DateTimeImmutable
	{
		return $this->pausedAt ?? $this->clock->now();
	}
}
