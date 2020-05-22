<?php

namespace Tests\Board;

use Azul\Board\Board;
use Azul\Tile\Color;
use Azul\Tile\Marker;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Tests\BaseUnit;

class BoardTest extends BaseUnit
{
	public function testPlaceTests_2inRow1_1isOnFloor(): void
	{
		$b = new Board();

		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_1));
		$this->assertEquals(0, $b->getFloorTilesCount());

		$b->placeTiles(new TileCollection([new Tile(Color::RED), new Tile(Color::RED)]), Board::ROW_1);
		$this->assertEquals(1, $b->getFloorTilesCount());
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_1));
	}

	public function testPlaceTests_1inRow2_NothingOnFloor(): void
	{
		$b = new Board();
		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_2));
		$this->assertEquals(0, $b->getFloorTilesCount());
		$b->placeTiles(new TileCollection([new Tile(Color::RED)]), Board::ROW_2);
		$this->assertEquals(0, $b->getFloorTilesCount());
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_2));
	}

	public function testPlaceTiles_TileAndMarker_TileOnFloor(): void
	{
		$b = new Board();
		$b->placeTiles(new TileCollection([new Marker(), new Tile(Color::RED)]), Board::ROW_2);
		$this->assertEquals(1, $b->getFloorTilesCount());
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_2));
	}

	public function testPlaceTiles_4TilesOn2Row_2OnFloor(): void
	{
		$b = new Board();
		$tiles = [new Tile(Color::RED), new Tile(Color::RED), new Tile(Color::RED), new Tile(Color::RED)];
		$b->placeTiles(new TileCollection($tiles), Board::ROW_2);
		$this->assertEquals(2, $b->getFloorTilesCount());
		$this->assertEquals(2, $b->getRowTilesCount(Board::ROW_2));
	}

	public function testGetDiscardedTiles_FilledRowsAndFloor_RowsFloorEmpty(): void
	{
		$b = new Board();
		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_1);
		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_1); // on floor

		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_2);
		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_3);
		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_4);
		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_5);
		$this->assertEquals(1, $b->getFloorTilesCount());
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_1));
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_2));
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_3));
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_4));
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_5));

		$tiles = $b->discardTiles();
		$this->assertEquals(6, $tiles->count());
		$this->assertEquals(0, $b->getFloorTilesCount());
		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_1));
		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_2));
		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_3));
		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_4));
		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_5));
	}
}