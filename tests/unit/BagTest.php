<?php

namespace Tests\unit;

use Azul\Game\Bag;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Azul\Tile\TileFactory;

class BagTest extends BaseUnit
{
	public function testGetNext_NoTiles_NoNext(): void
	{
		$bag = new Bag(new TileCollection());
		$this->assertEmpty($bag->getNextPlate());
	}

	public function testNextPlate_GameTiles_Get4Tiles(): void
	{
		$tiles = (new TileFactory())->createGameTiles();
		$bag = new Bag($tiles);
		$this->assertCount(4, $bag->getNextPlate());
	}

	public function testNextPlate_5Tiles_Get4TilesOnce(): void
	{
		$tiles = new TileCollection();
		for ($j = 0; $j < 5; $j++) {
			$tiles->addTile(new Tile(Color::BLACK));
		}
		$bag = new Bag($tiles);
		$this->assertCount(4, $bag->getNextPlate());
		$this->assertCount(0, $bag->getNextPlate());
	}

	public function testNextPlate_5TilesRefill4_Get4TilesTwice(): void
	{
		$tiles = new TileCollection(array_fill(1, 5, new Tile(Color::BLACK)));

		$bag = new Bag($tiles);
		$this->assertCount(4, $firstPlate = $bag->getNextPlate());
		$bag->discardTiles($firstPlate);
		$this->assertCount(4, $bag->getNextPlate());
	}

	public function testNextPlate_SameTiles_VariousPlatesAfterRefill(): void
	{
		$tilesFirst = new TileCollection();
		$tilesSecond = new TileCollection();
		for ($j = 0; $j < 4; $j++) {
			$tilesFirst->addTile(new Tile(Color::BLACK));
			$tilesFirst->addTile(new Tile(Color::CYAN));
			$tilesFirst->addTile(new Tile(Color::RED));

			$tilesSecond->addTile(new Tile(Color::BLACK));
			$tilesSecond->addTile(new Tile(Color::CYAN));
			$tilesSecond->addTile(new Tile(Color::RED));
		}
		$bag = new Bag(new TileCollection());
		$bag->discardTiles($tilesSecond);
		$firstHashes[] = $this->createPlateHashes($bag->getNextPlate());
		$firstHashes[] = $this->createPlateHashes($bag->getNextPlate());
		$firstHashes[] = $this->createPlateHashes($bag->getNextPlate());
		$bag->discardTiles($tilesSecond);
		$secondHashes[] = $this->createPlateHashes($bag->getNextPlate());
		$secondHashes[] = $this->createPlateHashes($bag->getNextPlate());
		$secondHashes[] = $this->createPlateHashes($bag->getNextPlate());
		$this->assertNotEquals(($firstHashes), ($secondHashes));
	}

	private function createPlateHashes(TileCollection $tiles): string
	{
		$hash = '';
		foreach ($tiles as $tile) {
			$hash .= $tile->getColor();
		}
		return $hash;
	}
}