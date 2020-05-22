<?php

namespace Tests\Board;

use Azul\Board\BoardRow;
use Azul\Board\Exception\BoardRowSizeExceededException;
use Azul\Board\Exception\BoardRowVariousColorsException;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Tests\BaseUnit;

class BoardRowTest extends BaseUnit
{
	public function testAdd_ExceedMaxSize_GotException(): void
	{
		$b = new BoardRow(1);
		$this->expectException(BoardRowSizeExceededException::class);
		$b->placeTiles(new TileCollection([new Tile(Color::YELLOW), new Tile(Color::YELLOW)]));
	}

	public function testAddTile_ExceedMaxSize_GotException(): void
	{
		$b = new BoardRow(1);
		$this->addTile($b, new Tile(Color::YELLOW));
		$this->expectException(BoardRowSizeExceededException::class);
		$this->addTile($b, new Tile(Color::YELLOW));
	}

	public function testAdd_OneTileIn2MaxSize_Okay(): void
	{
		$b = new BoardRow(2);
		$b->placeTiles(new TileCollection([new Tile(Color::YELLOW)]));
	}

	public function testAdd_TwoDifferentColors_GotException(): void
	{
		$b = new BoardRow(2);
		$this->addTile($b, new Tile(Color::YELLOW));
		$this->expectException(BoardRowVariousColorsException::class);
		$this->addTile($b, new Tile(Color::RED));
	}

	public function testAddTiles_DifferentColors_GotException(): void
	{
		$b = new BoardRow(5);
		$this->expectException(BoardRowVariousColorsException::class);
		$b->placeTiles(new TileCollection([new Tile(Color::YELLOW), new Tile(Color::RED)]));
	}

	public function testGetEmptySLots_3of5_2Empty(): void
	{
		$b = new BoardRow(5);
		$b->placeTiles(new TileCollection([new Tile(Color::RED), new Tile(Color::RED), new Tile(Color::RED)]));
		$this->assertEquals(2, $b->getEmptySlotsCount());
	}

	public function testIsMainColor_NoTiles_AnyColorIsMain(): void
	{
		$b = new BoardRow(1);
		foreach (Color::getAll() as $color) {
			$this->assertTrue($b->isMainColor($color));
		}
	}

	private function addTile(BoardRow $row, Tile $tile): void
	{
		$row->placeTiles(new TileCollection([$tile]));
	}
}