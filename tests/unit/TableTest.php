<?php

namespace Tests;

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
}