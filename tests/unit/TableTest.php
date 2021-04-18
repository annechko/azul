<?php

namespace Tests\unit;

use Azul\Game\Exception\MarkerAlreadyTakenException;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class TableTest extends BaseUnit
{
	public function testCountTotal_2DifferentColors_Total2(): void
	{
		$table = $this->tester->createGameTable();
		$table->addToCenterPile(new TileCollection([
			new Tile(Color::RED),
			new Tile(Color::CYAN),
		]));
		$this->assertEquals(2, $table->getTilesCount());
	}

	public function testCountTotal_2SameColors_Total2(): void
	{
		$table = $this->tester->createGameTable();
		$table->addToCenterPile(new TileCollection([
			new Tile(Color::RED),
			new Tile(Color::RED),
		]));
		$this->assertEquals(2, $table->getTilesCount());
	}

	public function testCountTotal_Empty_Total0(): void
	{
		$table = $this->tester->createGameTable();
		$this->assertEquals(0, $table->getTilesCount());
	}

	public function testCountByColor(): void
	{
		$table = $this->tester->createGameTable();
		$table->addToCenterPile(new TileCollection([
			new Tile(Color::RED),
			new Tile(Color::RED),
			new Tile(Color::CYAN),
			new Tile(Color::RED),
			new Tile(Color::CYAN),
			new Tile(Color::BLUE),
		]));
		$this->assertEquals(3, $table->getTilesCount(Color::RED));
		$this->assertEquals(2, $table->getTilesCount(Color::CYAN));
		$this->assertEquals(1, $table->getTilesCount(Color::BLUE));
		$this->assertEquals(0, $table->getTilesCount(Color::YELLOW));
	}

	public function testTakeMarker_HasMarker_NoMarkerAfter(): void
	{
		$table = $this->tester->createGameTable();
		$this->assertTrue($table->hasMarker());
		$marker = $table->takeMarker();
		$this->assertNotNull($marker);
		$this->assertFalse($table->hasMarker());
	}

	public function testTakeMarker_Twice_GotException(): void
	{
		$table = $this->tester->createGameTable();
		$table->takeMarker();
		$this->expectException(MarkerAlreadyTakenException::class);
		$table->takeMarker();
	}

	public function testTake_HasMarker_MarkerLeft(): void
	{
		$table = $this->tester->createGameTable();
		$color = Color::RED;
		$table->addToCenterPile(new TileCollection([
			new Tile($color),
		]));
		$this->assertTrue($table->hasMarker());
		$tiles = $table->take($color);
		$this->assertCount(1, $tiles);
		$this->assertTrue($table->hasMarker());
		$this->assertEquals(0, $table->getTilesCount());
	}
}