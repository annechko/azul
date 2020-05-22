<?php

namespace Tests;

use Azul\Board\Board;
use Azul\Board\BoardWall;
use Azul\Game\FactoryCollection;
use Azul\Game\Table;
use Azul\Player\Strategy\FastestGameStrategy;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class FastestStrategyTest extends BaseUnit
{
	public function testAct_RedFilledOnWall_TakeYellow(): void
	{
		$wall = $this->createMock(BoardWall::class);

		$wall->method('isColorFilled')
			->willReturnCallback(static function ($color, $row) {
				return $color === Color::RED && $row === Board::ROW_1;
			});

		$s = new FastestGameStrategy($b = new Board($wall));
		$b->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_2);
		$b->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_3);
		$b->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_4);
		$b->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_5);
		$table = new Table();
		$table->addToCenterPile(new TileCollection([new Tile(Color::RED), new Tile(Color::YELLOW)]));

		$this->assertEquals(1, $table->getTilesCount(Color::RED));
		$this->assertEquals(1, $table->getTilesCount(Color::YELLOW));
		$s->act(new FactoryCollection(), $table);
		$this->assertEquals(1, $table->getTilesCount(Color::RED));
		$this->assertEquals(0, $table->getTilesCount(Color::YELLOW));
	}
}