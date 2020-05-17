<?php

declare(strict_types=1);

namespace Azul\Game;

use Azul\Event\GameEvent;
use Azul\Event\PlayerFinishTurnEvent;
use Azul\Event\RoundCreatedEvent;
use Azul\Event\WallTiledEvent;
use Azul\Player\PlayerCollection;
use Azul\Tile\Marker;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Game
{
	private Bag $bag;
	private ?GameRound $round = null;
	private EventDispatcher $dispatcher;

	public function __construct(Bag $bag, ?EventDispatcher $dispatcher = null)
	{
		$this->bag = $bag;
		$this->dispatcher = $dispatcher;
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
				$this->dispatch(new RoundCreatedEvent($this->round));
			}
			if ($this->round->canContinue()) {
				foreach ($players as $player) {
					$player->act($this->round->getFactories(), $this->round->getTable());
					$this->dispatch(new PlayerFinishTurnEvent($player, $this->round));
				}
			} else {
				$this->round = null;
				foreach ($players as $player) {
					$player->doWallTiling();
					$this->dispatch(new WallTiledEvent($player));
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

	private function dispatch(GameEvent $event): void
	{
		if (!$this->dispatcher) {
			return;
		}
		$this->dispatcher->dispatch($event);
	}
}