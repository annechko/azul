<?php

namespace Tests\unit;

use Azul\Game\Bag;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class BagTest extends BaseUnit
{
	public function testGetNext_NoTiles_NoNext(): void
	{
		$bag = new Bag();
		$this->assertEmpty($bag->getNextPlate());
	}

	public function testGetNext_GameTiles_Got25Plates(): void
	{
		$bag = Bag::create();
		for ($j = 0; $j < 25; $j++) {
			$this->assertNotEmpty($bag->getNextPlate());
		}
		$this->assertEmpty($bag->getNextPlate());
	}

	public function testNextPlate_5Tiles_Get4TilesOnce(): void
	{
		$bag = (new Bag())->addTiles(Color::BLACK, 5);
		$this->assertCount(4, $bag->getNextPlate());
		$this->assertCount(0, $bag->getNextPlate());
	}

	public function testNextPlate_5TilesRefill4_Get4TilesTwice(): void
	{
		$bag = (new Bag())->addTiles(Color::BLACK, 5);
		$this->assertCount(4, $firstPlate = $bag->getNextPlate());
		$this->assertCount(0, $bag->getNextPlate());
		$bag->discardTiles($firstPlate);
		$this->assertCount(4, $bag->getNextPlate());
		$this->assertCount(0, $bag->getNextPlate());
	}

	public function testNextPlate_HasRedInTilesAndBlackInDiscard_UseDiscardedOnlyAfterTilesEmpty(): void
	{
		$bag = (new Bag())->addTiles($tileColor = Color::BLACK, 4);
		$bag->discardTiles(new TileCollection([
			new Tile(Color::RED),
			new Tile(Color::RED),
			new Tile(Color::RED),
			new Tile(Color::RED),
		]));
		$plate = $bag->getNextPlate();
		foreach ($plate as $tile) {
			$this->assertEquals($tileColor, $tile->getColor());
		}
		$nextPlate = $bag->getNextPlate();
		foreach ($nextPlate as $tile) {
			$this->assertNotEquals($tileColor, $tile->getColor());
		}
	}
}