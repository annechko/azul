<?php

namespace Tests;

use Azul\Board\Board;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class BoardTest extends BaseUnit
{
    public function testPlaceTests_2inRow1_1isOnFloor()
    {
        $b = new Board();

        $this->assertEquals(0, $b->getRowTilesCount(Board::ROW_1));
        $this->assertEquals(0, $b->getFloorTilesCount());

        $b->placeTiles(new TileCollection([new Tile(Color::RED), new Tile(Color::RED)]), Board::ROW_1);
        $this->assertEquals(1, $b->getFloorTilesCount());
        $this->assertEquals(1, $b->getRowTilesCount(Board::ROW_1));
    }

    public function testPlaceTests_1inRow2_NothingOnFloor()
    {
        $b = new Board();
        $this->assertEquals(0, $b->getRowTilesCount(Board::ROW_2));
        $this->assertEquals(0, $b->getFloorTilesCount());
        $b->placeTiles(new TileCollection([new Tile(Color::RED),]), Board::ROW_2);
        $this->assertEquals(0, $b->getFloorTilesCount());
        $this->assertEquals(1, $b->getRowTilesCount(Board::ROW_2));
    }
}