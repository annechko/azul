<?php

namespace Tests\unit;

use Azul\Board\Board;
use Azul\Game\Bag;
use Azul\Game\Game;
use Azul\Player\Player;
use Azul\Player\PlayerCollection;
use Azul\Tile\TileFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GameTest extends BaseUnit
{
	public function testPlay_2Players_gameHasEnding()
	{
		$players = new PlayerCollection([new Player(new Board()), new Player(new Board())]);
		$game = new Game(new Bag((new TileFactory())->createGameTiles()), $this->createMock(EventDispatcher::class));
		$game->play($players);
	}
}