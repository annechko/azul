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
		$b->placeTiles(new TileCollection([new Tile(Color::RED), new Marker()]), Board::ROW_2);
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

	public function testGetDiscardedTiles_TileOnFloor_FloorEmpty(): void
	{
		$b = new Board();
		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_1);
		$b->placeTiles(new TileCollection(new Tile(Color::RED)), Board::ROW_1); // on floor

		$this->assertEquals(1, $b->getFloorTilesCount());
		$this->assertEquals(1, $b->getRowTilesCount(Board::ROW_1));

		$tiles = $b->discardTiles();
		$this->assertEquals(2, $tiles->count());
		$this->assertEquals(0, $b->getFloorTilesCount());
		$this->assertEquals(0, $b->getRowTilesCount(Board::ROW_1));
	}

	public function testGetDiscardedTiles_RowsFull_AllTilesDiscarded(): void
	{
		$board = new Board();
		$board->placeTiles($this->buildTiles(1), Board::ROW_1);
		$board->placeTiles($this->buildTiles(2), Board::ROW_2);
		$board->placeTiles($this->buildTiles(3), Board::ROW_3);
		$board->placeTiles($this->buildTiles(4), Board::ROW_4);
		$board->placeTiles($this->buildTiles(5), Board::ROW_5);
		$tiles = $board->discardTiles();
		$this->assertCount(15, $tiles);
	}

	public function testGetDiscardedTiles_EmptyRows_NoTilesDiscarded(): void
	{
		$board = new Board();
		$tiles = $board->discardTiles();
		$this->assertCount(0, $tiles);
	}

	public function testGetDiscardedTiles_2Row1Tile_1TileDiscarded(): void
	{
		$rowNumber = Board::ROW_2;
		$board = new Board();
		$board->placeTiles($this->buildTiles(1), $rowNumber);

		$this->assertEquals(1, $board->getRowTilesCount($rowNumber));
		$tiles = $board->discardTiles();
		$this->assertCount(0, $tiles);
		$this->assertEquals(1, $board->getRowTilesCount($rowNumber));
	}

	private function buildTiles(int $numberOfTiles): TileCollection
	{
		return new TileCollection(array_fill(1, $numberOfTiles, new Tile(Color::BLUE)));
	}
}