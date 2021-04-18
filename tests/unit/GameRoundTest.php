<?php

namespace Tests\unit;

use Azul\Game\Factory;
use Azul\Game\GameRound;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class GameRoundTest extends BaseUnit
{
	public function testKeepPlaying_EmptyFactoriesAndTable_False(): void
	{
		$t = $this->tester->createGameTable();
		$round = new GameRound($t,
			[
				$f = new Factory(
					new TileCollection([
						new Tile(Color::CYAN),
						new Tile(Color::CYAN),
						new Tile(Color::CYAN),
						new Tile(Color::CYAN),
					])
				),
			]
		);
		$this->assertTrue($round->canContinue());
		$f->take(Color::CYAN);
		$this->assertFalse($round->canContinue());
	}
}