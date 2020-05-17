<?php

declare(strict_types=1);

namespace Azul\Event;

use Azul\Game\GameRound;
use Azul\Player\Player;

class PlayerFinishTurnEvent extends GameEvent
{
	private Player $player;
	protected GameRound $round;

	public function __construct(Player $player, GameRound $round)
	{
		$this->player = $player;
		$this->round = $round;
	}

	public function getRound(): GameRound
	{
		return $this->round;
	}

	public function getPlayer(): Player
	{
		return $this->player;
	}
}