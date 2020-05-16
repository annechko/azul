<?php

declare(strict_types=1);

namespace Azul\Game;

use Azul\Player\PlayerCollection;
use Azul\Tile\Marker;

class Game
{
	private Bag $bag;
	private ?GameRound $round = null;

	public function __construct(Bag $bag)
	{
		$this->bag = $bag;
	}

	public function play(PlayerCollection $players): void
	{
		while (true) {
			if (!$this->round) {
				foreach ($players as $player) {
					if ($player->isGameOver()) {
						return;
					}
				}
				$this->round = $this->createRound($players);
			}
			if ($this->round->canContinue()) {
				foreach ($players as $player) {
					$player->act($this->round->getFactories(), $this->round->getTable());
				}
			} else {
				$this->round = null;
				foreach ($players as $player) {
					$player->doWallTiling();
					$this->bag->discardTiles($player->getDiscardedTiles());
				}
			}
		}
	}

	private function createRound(PlayerCollection $players): GameRound
	{
		$table = new Table(new Marker());
		return new GameRound(
			$table,
			[
				new Factory($table, $this->bag->getNextPlate()),
				new Factory($table, $this->bag->getNextPlate()),
				new Factory($table, $this->bag->getNextPlate()),
				new Factory($table, $this->bag->getNextPlate()),
				new Factory($table, $this->bag->getNextPlate()),
			]
		);
	}
}