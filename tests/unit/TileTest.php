<?php

namespace Tests;

use Azul\Tile\Color;
use Azul\Tile\Tile;

class TileTest extends \Codeception\Test\Unit
{
    public function testCreate_Red_ColorIsRight()
    {
        $tile = Tile::createRed();
        $this->assertTrue($this->isRed($tile));
        $this->assertFalse($this->isCyan($tile));
        $this->assertFalse($this->isBlue($tile));
        $this->assertFalse($this->isBlack($tile));
        $this->assertFalse($this->isYellow($tile));
    }

    public function testCreate_Black_ColorIsRight()
    {
        $tile = Tile::createBlack();
        $this->assertTrue($this->isBlack($tile));
        $this->assertFalse($this->isRed($tile));
        $this->assertFalse($this->isCyan($tile));
        $this->assertFalse($this->isBlue($tile));
        $this->assertFalse($this->isYellow($tile));
    }

    public function testCreate_Yellow_ColorIsRight()
    {
        $tile = Tile::createYellow();
        $this->assertTrue($this->isYellow($tile));
        $this->assertFalse($this->isBlack($tile));
        $this->assertFalse($this->isRed($tile));
        $this->assertFalse($this->isCyan($tile));
        $this->assertFalse($this->isBlue($tile));
    }

    public function testCreate_Cyan_ColorIsRight()
    {
        $tile = Tile::createCyan();
        $this->assertTrue($this->isCyan($tile));
        $this->assertFalse($this->isBlack($tile));
        $this->assertFalse($this->isRed($tile));
        $this->assertFalse($this->isYellow($tile));
        $this->assertFalse($this->isBlue($tile));
    }

    public function testCreate_Blue_ColorIsRight()
    {
        $tile = Tile::createBlue();
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