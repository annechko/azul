<?php

namespace Tests;

use Azul\Game\Exception\MarkerAlreadyTakenException;
use Azul\Game\Exception\MarkerCanNotBeTakenException;
use Azul\Game\Exception\MarkerShouldHaveBeenTakenException;
use Azul\Game\Table;
use Azul\Tile\Color;
use Azul\Tile\Tile;

class TableTest extends \Codeception\Test\Unit
{
    public function testCountTotal_2DifferentColors_Total2()
    {
        $table = new Table();
        $table->addToCenterPile([
            new Tile(Color::RED),
            new Tile(Color::CYAN),
        ]);
        $this->assertEquals(2, $table->getCenterPileCount());
    }

    public function testCountTotal_2SameColors_Total2()
    {
        $table = new Table();
        $table->addToCenterPile([
            new Tile(Color::RED),
            new Tile(Color::RED),
        ]);
        $this->assertEquals(2, $table->getCenterPileCount());
    }

    public function testCountTotal_Empty_Total0()
    {
        $table = new Table();
        $this->assertEquals(0, $table->getCenterPileCount());
    }

    public function testCountByColor()
    {
        $table = new Table();
        $table->addToCenterPile([
            new Tile(Color::RED),
            new Tile(Color::RED),
            new Tile(Color::CYAN),
            new Tile(Color::RED),
            new Tile(Color::CYAN),
            new Tile(Color::BLUE),
        ]);
        $this->assertEquals(3, $table->getCenterPileCount(Color::RED));
        $this->assertEquals(2, $table->getCenterPileCount(Color::CYAN));
        $this->assertEquals(1, $table->getCenterPileCount(Color::BLUE));
        $this->assertEquals(0, $table->getCenterPileCount(Color::YELLOW));
    }

    public function testTake_TakeTwice_SecondGotMarkerException()
    {
        $table = new Table();
        $table->addToCenterPile([
            new Tile(Color::RED),
            new Tile(Color::CYAN),
        ]);
        $this->assertTrue($table->hasStartingPlayerMarker());
        $table->take(Color::RED);
        $this->expectException(MarkerShouldHaveBeenTakenException::class);
        $table->take(Color::CYAN);
    }

    public function testTakeMarker_TakeTwiceWithMarker_NoMarkerException()
    {
        $table = new Table();
        $table->addToCenterPile([
            new Tile(Color::RED),
            new Tile(Color::CYAN),
        ]);
        $this->assertTrue($table->hasStartingPlayerMarker());
        $table->take(Color::RED);
        $table->takeMarker();
        $table->take(Color::CYAN);
    }

    public function testTakeMarker_TakeTwice_GotMarkerException()
    {
        $table = new Table();
        $table->addToCenterPile([
            new Tile(Color::RED),
            new Tile(Color::CYAN),
        ]);
        $this->assertTrue($table->hasStartingPlayerMarker());
        $table->take(Color::RED);
        $table->takeMarker();
        $this->expectException(MarkerAlreadyTakenException::class);
        $table->takeMarker();
    }

    public function testTakeMarker_NoTilesInCenter_GotMarkerException()
    {
        $table = new Table();
        $table->addToCenterPile([
            new Tile(Color::RED),
            new Tile(Color::CYAN),
        ]);
        $this->assertTrue($table->hasStartingPlayerMarker());
        $this->expectException(MarkerCanNotBeTakenException::class);
        $table->takeMarker();
    }
}