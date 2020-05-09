<?php

namespace Tests;

use Azul\Tile\Tile;

class TileTest extends \Codeception\Test\Unit
{
    public function testCreate_Red_ColorIsRight()
    {
        $tile = Tile::createRed();
        $this->assertTrue($tile->isRed());
        $this->assertFalse($tile->isCyan());
        $this->assertFalse($tile->isBlue());
        $this->assertFalse($tile->isBlack());
        $this->assertFalse($tile->isYellow());
    }

    public function testCreate_Black_ColorIsRight()
    {
        $tile = Tile::createBlack();
        $this->assertTrue($tile->isBlack());
        $this->assertFalse($tile->isRed());
        $this->assertFalse($tile->isCyan());
        $this->assertFalse($tile->isBlue());
        $this->assertFalse($tile->isYellow());
    }

    public function testCreate_Yellow_ColorIsRight()
    {
        $tile = Tile::createYellow();
        $this->assertTrue($tile->isYellow());
        $this->assertFalse($tile->isBlack());
        $this->assertFalse($tile->isRed());
        $this->assertFalse($tile->isCyan());
        $this->assertFalse($tile->isBlue());
    }

    public function testCreate_Cyan_ColorIsRight()
    {
        $tile = Tile::createCyan();
        $this->assertTrue($tile->isCyan());
        $this->assertFalse($tile->isBlack());
        $this->assertFalse($tile->isRed());
        $this->assertFalse($tile->isYellow());
        $this->assertFalse($tile->isBlue());
    }

    public function testCreate_Blue_ColorIsRight()
    {
        $tile = Tile::createBlue();
        $this->assertTrue($tile->isBlue());
        $this->assertFalse($tile->isBlack());
        $this->assertFalse($tile->isRed());
        $this->assertFalse($tile->isYellow());
        $this->assertFalse($tile->isCyan());
    }
}