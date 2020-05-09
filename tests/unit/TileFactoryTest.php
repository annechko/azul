<?php

namespace Tests;

use Azul\Tile\TileFactory;

class TileFactoryTest extends \Codeception\Test\Unit
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
            if ($tile->isRed()) {
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
            if ($tile->isBlue()) {
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
            if ($tile->isBlack()) {
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
            if ($tile->isCyan()) {
                $count++;
            }
        }
        $this->assertEquals(20, $count);
    }

    private function createTiles()
    {
        return (new TileFactory())->createGameTiles();
    }
}