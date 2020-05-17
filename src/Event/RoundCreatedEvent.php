<?php

declare(strict_types=1);

namespace Azul\Event;

use Azul\Game\GameRound;

class RoundCreatedEvent extends GameEvent
{
	protected GameRound $round;

	public function __construct(GameRound $round)
	{
		$this->round = $round;
	}

	public function getRound(): GameRound
	{
		return $this->round;
	}
}