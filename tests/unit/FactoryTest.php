<?php

namespace Tests\unit;

use Azul\Game\Factory;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class FactoryTest extends BaseUnit
{
	public function testTakeRed_3Red1Black_1TileLeft(): void
	{
		$factory = new Factory(
			new TileCollection([
				new Tile(Color::RED),
				new Tile(Color::RED),
				new Tile(Color::RED),
				new Tile(Color::BLACK),
			])
		);
		$this->assertEquals(3, $factory->getTilesCount(Color::RED));
		$this->assertEquals(1, $factory->getTilesCount(Color::BLACK));
		$tiles = $factory->take(Color::RED);
		$this->assertCount(3, $tiles);
		$this->assertEquals(0, $factory->getTilesCount(Color::RED));
		$this->assertEquals(1, $factory->getTilesCount(Color::BLACK));
	}

	public function testTakeAll_3Red1Black_NoTilesLeft(): void
	{
		$factory = new Factory(
			new TileCollection([
				new Tile(Color::RED),
				new Tile(Color::RED),
				new Tile(Color::RED),
				new Tile(Color::BLACK),
			])
		);
		$this->assertEquals(3, $factory->getTilesCount(Color::RED));
		$this->assertEquals(1, $factory->getTilesCount(Color::BLACK));
		$tiles = $factory->takeAll();
		$this->assertCount(4, $tiles);
		$this->assertEquals(0, $factory->getTilesCount(Color::RED));
		$this->assertEquals(0, $factory->getTilesCount(Color::BLACK));
		$this->assertEquals(0, $factory->getTilesCount());
	}

	public function testTake_NoExistedColor_Exception(): void
	{
		$factory = new Factory(
			new TileCollection(array_fill(0, 4, new Tile(Color::BLACK)))
		);
		$this->expectExceptionMessageRegExp('#at least 1#');
		$factory->take(Color::CYAN);
	}
}