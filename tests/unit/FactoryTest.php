<?php

namespace Tests;

use Azul\Game\Factory;
use Azul\Game\Table;
use Azul\Tile\Color;
use Azul\Tile\Tile;

class FactoryTest extends \Codeception\Test\Unit
{
    public function testTakeRed_3Red1Black_1TileLeftInCenter()
    {
        $table = new Table();
        $factory = new Factory(
            $table,
            [
                new Tile(Color::RED),
                new Tile(Color::RED),
                new Tile(Color::RED),
                new Tile(Color::BLACK),
            ]
        );
        $this->assertEquals(0, $table->getCenterPileCount());
        $factory->take(Color::RED);
        $this->assertEquals(1, $table->getCenterPileCount());
    }

}