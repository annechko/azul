<?php

namespace Tests\Board;

use Azul\Board\Board;
use Azul\Board\BoardRow;
use Azul\Board\BoardWall;
use Azul\Board\Exception\BoardWallColorAlreadyFilledException;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Tests\BaseUnit;

class BoardWallTest extends BaseUnit
{
    public function testIsCompleted_AllColorsRow_True(): void
    {
        $wall = new BoardWall();
        $this->assertFalse($wall->isCompleted(Board::ROW_1));
        foreach (Color::getAll() as $color) {
            $row = new BoardRow(1);
            $row->addTile(new Tile($color));
            $wall->fillColor($row);
        }
        $this->assertTrue($wall->isCompleted(Board::ROW_1));
    }

    public function testPlaceTiles_OneColorTwoTimes_Exception(): void
    {
        $wall = new BoardWall();
        $row = new BoardRow(1);
        $row->addTile(new Tile(Color::RED));
        $wall->fillColor($row);
        $this->expectException(BoardWallColorAlreadyFilledException::class);
        $wall->fillColor($row);
    }

    public function testIsColorFilled_PlaceRed_True(): void
    {
        $wall = new BoardWall();
        $row = new BoardRow(1);
        $row->addTile(new Tile(Color::RED));
        $wall->fillColor($row);
        $this->assertTrue($wall->isColorFilledByRow($row));
    }

    public function testIsColorFilled_NothingPlaced_False(): void
    {
        $wall = new BoardWall();
        foreach (Color::getAll() as $color) {
            $this->assertFalse($wall->isColorFilled($color, Board::ROW_1));
            $this->assertFalse($wall->isColorFilled($color, Board::ROW_2));
            $this->assertFalse($wall->isColorFilled($color, Board::ROW_3));
            $this->assertFalse($wall->isColorFilled($color, Board::ROW_4));
            $this->assertFalse($wall->isColorFilled($color, Board::ROW_5));
        }
    }
}