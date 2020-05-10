<?php

namespace Tests;

use Azul\Board\BoardRow;
use Azul\Board\Exception\BoardRowSizeExceededException;
use Azul\Board\Exception\BoardRowVariousColorsException;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class BoardRowTest extends BaseUnit
{
    public function testAdd_ExceedMaxSize_GotException()
    {
        $b = new BoardRow(1);
        $this->expectException(BoardRowSizeExceededException::class);
        $b->addTiles(new TileCollection([new Tile(Color::YELLOW), new Tile(Color::YELLOW)]));
    }

    public function testAddTile_ExceedMaxSize_GotException()
    {
        $b = new BoardRow(1);
        $b->addTile(new Tile(Color::YELLOW));
        $this->expectException(BoardRowSizeExceededException::class);
        $b->addTile(new Tile(Color::YELLOW));
    }

    public function testAdd_OneTileIn2MaxSize_Okay()
    {
        $b = new BoardRow(2);
        $b->addTiles(new TileCollection([new Tile(Color::YELLOW),]));
    }

    public function testAdd_TwoDifferentColors_GotException()
    {
        $b = new BoardRow(2);
        $b->addTile(new Tile(Color::YELLOW));
        $this->expectException(BoardRowVariousColorsException::class);
        $b->addTile(new Tile(Color::RED));
    }

    public function testAddTiles_DifferentColors_GotException()
    {
        $b = new BoardRow(5);
        $this->expectException(BoardRowVariousColorsException::class);
        $b->addTiles(new TileCollection([new Tile(Color::YELLOW), new Tile(Color::RED)]));
    }


    public function testGetEmptySLots_3of5_2Empty()
    {
        $b = new BoardRow(5);
        $b->addTiles(new TileCollection([new Tile(Color::RED), new Tile(Color::RED), new Tile(Color::RED)]));
        $this->assertEquals(2, $b->getEmptySlotsCount());
    }

    public function testIsMainColor_NoTiles_AnyColorIsMain()
    {
        $b = new BoardRow(1);
        foreach (Color::getAll() as $color) {
            $this->assertTrue($b->isMainColor($color));
        }
    }
}