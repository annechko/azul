<?php

namespace Tests\unit;

use Azul\Board\Board;
use Azul\Board\BoardRow;
use Azul\Board\BoardWall;
use Azul\Game\Factory;
use Azul\Game\FactoryCollection;
use Azul\Player\Player;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class PlayerTest extends BaseUnit
{
	public function testGetNextMove_ReturnMoveObject(): void
	{
		$player = new Player(new Board());
		$factory = new Factory(new TileCollection([new Tile(Color::BLUE)]));
		$move = $player->getNextMove(new FactoryCollection([$factory]),
			$this->tester->createGameTable());
		$this->assertNotNull($move);
	}

	public function testGetNextMove_TiledFactoryEmptyTable_TookTilesFromFactory(): void
	{
		$player = new Player(new Board());
		$t = $this->tester->createGameTable();
		$factory = new Factory(new TileCollection([new Tile(Color::BLUE)]));

		$move = $player->getNextMove(new FactoryCollection([$factory]), $t);
		$this->assertFalse($move->isFromTable());
	}

	public function testGetNextMove_EmptyFactoryTiledTable_TookTilesFromTable(): void
	{
		$player = new Player(new Board());
		$t = $this->tester->createGameTable();
		$t->addToCenterPile(new TileCollection([new Tile(Color::BLUE)]));

		$move = $player->getNextMove(new FactoryCollection([new Factory(new TileCollection())]),
			$t);
		$this->assertTrue($move->isFromTable());
	}

	public function testGetNextMove_AllWallRowsHasRedTile_TookTilesAnyway(): void
	{
		$player = new Player($board = new Board());
		$board->placeTiles(new TileCollection([new Tile(Color::RED)]), Board::ROW_1);
		$board->placeTiles(new TileCollection([new Tile(Color::RED)]), Board::ROW_2);
		$board->placeTiles(new TileCollection([new Tile(Color::RED)]), Board::ROW_3);
		$board->placeTiles(new TileCollection([new Tile(Color::RED)]), Board::ROW_4);
		$board->placeTiles(new TileCollection([new Tile(Color::RED)]), Board::ROW_5);
		$t = $this->tester->createGameTable(null);
		$t->addToCenterPile(new TileCollection([new Tile(Color::BLACK)]));

		$this->assertEquals(0, $board->getFloorTilesCount());
		$move = $player->getNextMove(new FactoryCollection([new Factory(new TileCollection())]), $t);
		$this->assertNotNull($move->getColor());
		$this->assertNotNull($move->getRowNumber());
	}

	public function testIsGameOver_AllTilesOnWallAreFilled_True(): void
	{
		$wall = new BoardWall();
		foreach (Color::getAll() as $color) {
			$row = new BoardRow(1);
			$row->placeTiles(new TileCollection([new Tile($color)]));
			$wall->fillColor($row);
		}
		$player = new Player($board = new Board($wall));
		$this->assertTrue($player->isGameOver());
	}

	public function testIsGameOver_HasEmptyColors_False(): void
	{
		$wall = new BoardWall();

		$count = count(Color::getAll());
		$colorsCount = 0;
		foreach (Color::getAll() as $color) {
			$colorsCount++;
			$row = new BoardRow(1);
			$row->placeTiles(new TileCollection([new Tile($color)]));
			$wall->fillColor($row);
			$player = new Player($board = new Board($wall));

			if ($colorsCount === $count) {
				$this->assertTrue($player->isGameOver());
			} else {
				$this->assertFalse($player->isGameOver());
			}
		}
	}
}