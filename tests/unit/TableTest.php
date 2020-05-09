<?php

namespace Tests;

use Azul\Tile\Color;
use Azul\Tile\Marker;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class TableTest extends BaseUnit
{
    public function testCountTotal_2DifferentColors_Total2()
    {
        $table = $this->tester->createGameTable();
        $table->addToCenterPile(new TileCollection([
            new Tile(Color::RED),
            new Tile(Color::CYAN),
        ]));
        $this->assertEquals(2, $table->getCenterPileCount());
    }

    public function testCountTotal_2SameColors_Total2()
    {
        $table = $this->tester->createGameTable();
        $table->addToCenterPile(new TileCollection([
            new Tile(Color::RED),
            new Tile(Color::RED),
        ]));
        $this->assertEquals(2, $table->getCenterPileCount());
    }

    public function testCountTotal_Empty_Total0()
    {
        $table = $this->tester->createGameTable();
        $this->assertEquals(0, $table->getCenterPileCount());
    }

    public function testCountByColor()
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
        $this->assertEquals(3, $table->getCenterPileCount(Color::RED));
        $this->assertEquals(2, $table->getCenterPileCount(Color::CYAN));
        $this->assertEquals(1, $table->getCenterPileCount(Color::BLUE));
        $this->assertEquals(0, $table->getCenterPileCount(Color::YELLOW));
    }

    public function testTake_TakeTwice_FirstPileWithMarker()
    {
        $table = $this->tester->createGameTable();
        $table->addToCenterPile(new TileCollection([
            new Tile(Color::RED),
            new Tile(Color::CYAN),
        ]));
        $this->assertCount(2, $table->take(Color::RED));
        $this->assertCount(1, $table->take(Color::CYAN));
    }

    public function testTake_TakeAll_MarkerTaken()
    {
        $table = $this->tester->createGameTable();
        $table->addToCenterPile(new TileCollection([
            new Tile(Color::RED),
        ]));
        $this->assertCount(2, $tiles = $table->take(Color::RED));
        foreach ($tiles as $takenTile) {
            if ($takenTile->isFirstPlayerMarker()) {
                $marker = $takenTile;
            } else {
                $tile = $takenTile;
            }
        }
        $this->assertInstanceOf(Marker::class, $marker);
        $this->assertInstanceOf(Tile::class, $tile);
    }
}