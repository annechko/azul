<?php

namespace Tests;

use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileFactory;

class TileFactoryTest extends BaseUnit
{
    public function testCreateGameTiles_TotalCountOk()
    {
        $this->assertCount(100, $this->createTiles());
    }

    public function testCreate_Contains20Red()
    {
        $tiles = $this->createTiles();
        $count = 0;
        foreach ($tiles as $tile) {
            if ($tile->isSameColor(Color::RED)) {
                $count++;
            }
        }
        $this->assertEquals(20, $count);
    }

    public function testCreate_Contains20Blue()
    {
        $tiles = $this->createTiles();
        $count = 0;
        foreach ($tiles as $tile) {
            if ($tile->isSameColor(Color::BLUE)) {
                $count++;
            }
        }
        $this->assertEquals(20, $count);
    }

    public function testCreate_Contains20Black()
    {
        $tiles = $this->createTiles();
        $count = 0;
        foreach ($tiles as $tile) {
            if ($tile->isSameColor(Color::BLACK)) {
                $count++;
            }
        }
        $this->assertEquals(20, $count);
    }

    public function testCreate_Contains20Cyan()
    {
        $tiles = $this->createTiles();
        $count = 0;
        foreach ($tiles as $tile) {
            if ($tile->isSameColor(Color::CYAN)) {
                $count++;
            }
        }
        $this->assertEquals(20, $count);
    }

    /**
     * @return Tile[]
     */
    private function createTiles()
    {
        return (new TileFactory())->createGameTiles();
    }
}