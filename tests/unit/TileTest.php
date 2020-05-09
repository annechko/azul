<?php

namespace Tests;

use Azul\Tile\Color;
use Azul\Tile\Tile;

class TileTest extends BaseUnit
{
    public function testCreate_Red_ColorIsRight()
    {
        $tile = new Tile(Color::RED);
        $this->assertTrue($this->isRed($tile));
        $this->assertFalse($this->isCyan($tile));
        $this->assertFalse($this->isBlue($tile));
        $this->assertFalse($this->isBlack($tile));
        $this->assertFalse($this->isYellow($tile));
    }

    public function testCreate_Black_ColorIsRight()
    {
        $tile = new Tile(Color::BLACK);
        $this->assertTrue($this->isBlack($tile));
        $this->assertFalse($this->isRed($tile));
        $this->assertFalse($this->isCyan($tile));
        $this->assertFalse($this->isBlue($tile));
        $this->assertFalse($this->isYellow($tile));
    }

    public function testCreate_Yellow_ColorIsRight()
    {
        $tile = new Tile(Color::YELLOW);
        $this->assertTrue($this->isYellow($tile));
        $this->assertFalse($this->isBlack($tile));
        $this->assertFalse($this->isRed($tile));
        $this->assertFalse($this->isCyan($tile));
        $this->assertFalse($this->isBlue($tile));
    }

    public function testCreate_Cyan_ColorIsRight()
    {
        $tile = new Tile(Color::CYAN);
        $this->assertTrue($this->isCyan($tile));
        $this->assertFalse($this->isBlack($tile));
        $this->assertFalse($this->isRed($tile));
        $this->assertFalse($this->isYellow($tile));
        $this->assertFalse($this->isBlue($tile));
    }

    public function testCreate_Blue_ColorIsRight()
    {
        $tile = new Tile(Color::BLUE);
        $this->assertTrue($this->isBlue($tile));
        $this->assertFalse($this->isBlack($tile));
        $this->assertFalse($this->isRed($tile));
        $this->assertFalse($this->isYellow($tile));
        $this->assertFalse($this->isCyan($tile));
    }

    private function isBlack(Tile $tile)
    {
        return $tile->isSameColor(Color::BLACK);
    }

    private function isBlue(Tile $tile)
    {
        return $tile->isSameColor(Color::BLUE);
    }

    private function isRed(Tile $tile)
    {
        return $tile->isSameColor(Color::RED);
    }

    private function isYellow(Tile $tile)
    {
        return $tile->isSameColor(Color::YELLOW);
    }

    private function isCyan(Tile $tile)
    {
        return $tile->isSameColor(Color::CYAN);
    }
}