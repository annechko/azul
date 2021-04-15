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
	public function testAct_TiledFactoryEmptyTable_IncreaseBoardTilesByFactory(): void
	{
		$player = new Player($board = new Board());
		$t = $this->tester->createGameTable();
		$factory = new Factory($t, new TileCollection([new Tile(Color::BLUE)]));
		foreach ($board->getRows() as $row) {
			$this->assertEquals(0, $row->getTilesCount());
		}

		$player->act(new FactoryCollection([$factory]), $t);

		$counts = [];
		foreach ($board->getRows() as $row) {
			$counts[] = $row->getTilesCount();
		}
		$this->assertContains(1, $counts);
		$this->assertEquals(0, $factory->getTilesCount());
	}

	public function testAct_EmptyFactoryTiledTable_IncreaseBoardTilesByTable(): void
	{
		$player = new Player($board = new Board());
		$t = $this->tester->createGameTable();
		$t->addToCenterPile(new TileCollection([new Tile(Color::BLUE)]));

		foreach ($board->getRows() as $row) {
			$this->assertEquals(0, $row->getTilesCount());
		}

		$player->act(new FactoryCollection([new Factory($t, new TileCollection())]), $t);

		$counts = [];
		foreach ($board->getRows() as $row) {
			$counts[] = $row->getTilesCount();
		}
		$this->assertContains(1, $counts);
		$this->assertEquals(0, $t->getTilesCount());
	}

	public function testAct_FullRowsTableHasTiles_TilePlacedOnFloor(): void
	{
		$player = new Player($board = new Board());
		$board->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_1);
		$board->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_2);
		$board->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_3);
		$board->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_4);
		$board->placeTiles(new TileCollection([new Tile(Color::BLUE)]), Board::ROW_5);
		$t = $this->tester->createGameTable(null);
		$t->addToCenterPile(new TileCollection([new Tile(Color::RED)]));

		$this->assertEquals(0, $board->getFloorTilesCount());
		$player->act(new FactoryCollection([new Factory($t, new TileCollection())]), $t);
		$this->assertEquals(1, $board->getFloorTilesCount());
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