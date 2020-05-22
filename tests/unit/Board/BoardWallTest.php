<?php

namespace Tests\Board;

use Azul\Board\Board;
use Azul\Board\BoardRow;
use Azul\Board\BoardWall;
use Azul\Board\Exception\BoardWallColorAlreadyFilledException;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Tests\BaseUnit;

class BoardWallTest extends BaseUnit
{
	public function testIsCompleted_AllColorsRow_True(): void
	{
		$wall = new BoardWall();
		$this->assertFalse($wall->isCompleted(Board::ROW_1));
		foreach (Color::getAll() as $color) {
			$row = new BoardRow(1);
			$this->addTile($row, new Tile($color));
			$wall->fillColor($row);
		}
		$this->assertTrue($wall->isCompleted(Board::ROW_1));
	}

	public function testPlaceTiles_OneColorTwoTimes_Exception(): void
	{
		$wall = new BoardWall();
		$row = new BoardRow(1);
		$this->addTile($row, new Tile(Color::RED));
		$wall->fillColor($row);
		$this->expectException(BoardWallColorAlreadyFilledException::class);
		$wall->fillColor($row);
	}

	public function testIsColorFilled_PlaceRed_True(): void
	{
		$wall = new BoardWall();
		$row = new BoardRow(1);
		$this->addTile($row, new Tile(Color::RED));
		$wall->fillColor($row);
		$this->assertTrue($wall->isColorFilledByRow($row));
	}

	public function testIsColorFilled_NothingPlaced_False(): void
	{
		$wall = new BoardWall();
		foreach (Color::getAll() as $color) {
			for ($maxTiles = 1; $maxTiles <= 5; $maxTiles++) {
				$this->assertFalse($wall->isColorFilledByRow(
					$this->construct(BoardRow::class, ['maxTiles' => $maxTiles], ['getMainColor' => $color])
				));
			}
		}
	}

	private function addTile(BoardRow $row, Tile $tile): void
	{
		$row->placeTiles(new TileCollection([$tile]));
	}
}