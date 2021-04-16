<?php

namespace Tests\unit\Board;

use Azul\Board\Board;
use Azul\Board\BoardRow;
use Azul\Board\BoardWall;
use Azul\Board\Exception\BoardWallColorAlreadyFilledException;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Tests\unit\BaseUnit;

class BoardWallTest extends BaseUnit
{
	public function testIsAnyRowCompleted_EmptyWall_False(): void
	{
		$wall = new BoardWall();
		$this->assertFalse($wall->isAnyRowCompleted());
	}

	public function testIsAnyRowCompleted_AllColorsOnFirstRow_True(): void
	{
		$wall = new BoardWall();
		foreach (Color::getAll() as $color) {
			$row = new BoardRow(1);
			$this->addTile($row, new Tile($color));
			$wall->fillColor($row);
		}
		$this->assertTrue($wall->isAnyRowCompleted());
	}

	public function testIsAnyRowCompleted_AllColorsOnAllRows_True(): void
	{
		$wall = new BoardWall();
		foreach (Color::getAll() as $color) {
			foreach (Board::getRowNumbers() as $rowNumber) {
				$row = new BoardRow($rowNumber);
				for ($i = 0; $i < $rowNumber; $i++) {
					$this->addTile($row, new Tile($color));
				}
				$wall->fillColor($row);
			}
		}
		$this->assertTrue($wall->isAnyRowCompleted());
	}

	public function testFillColor_SecondRowCompleted_TileTakenFromRow(): void
	{
		$wall = new BoardWall();
		$row = new BoardRow(2);
		$this->addTile($row, new Tile(Color::BLUE));
		$this->addTile($row, new Tile(Color::BLUE));

		$wall->fillColor($row);

		$this->assertCount(1, $row->getTiles());
	}

	public function testFillColor_FirstRowCompleted_TileTakenFromRow(): void
	{
		$wall = new BoardWall();
		$row = new BoardRow(1);
		$this->addTile($row, new Tile(Color::RED));

		$wall->fillColor($row);

		$this->assertCount(0, $row->getTiles());
	}

	public function testPlaceTiles_OneColorTwoTimes_Exception(): void
	{
		$wall = new BoardWall();
		$row = new BoardRow(2);
		$this->addTile($row, new Tile(Color::RED));
		$wall->fillColor($row);
		$this->expectException(BoardWallColorAlreadyFilledException::class);
		$this->addTile($row, new Tile(Color::RED));
		$wall->fillColor($row);
	}

	public function testIsColorFilled_PlaceRed_True(): void
	{
		$wall = new BoardWall();
		$row = new BoardRow(1);
		$color = Color::RED;
		$this->assertFalse($wall->isColorFilled($color, Board::ROW_1));
		$this->addTile($row, new Tile($color));
		$wall->fillColor($row);
		$this->assertTrue($wall->isColorFilled($color, Board::ROW_1));
	}

	public function testIsColorFilled_NothingPlaced_False(): void
	{
		$wall = new BoardWall();
		$wall->isColorFilledByRow(
			$this->construct(BoardRow::class, ['maxTiles' => 1],
				['getMainColor' => Color::BLACK])
		);
	}

	private function addTile(BoardRow $row, Tile $tile): void
	{
		$row->placeTiles(new TileCollection([$tile]));
	}
}