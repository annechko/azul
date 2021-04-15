<?php

namespace Tests\unit;

use Azul\Tile\Color;
use Azul\Tile\Tile;

class TileTest extends BaseUnit
{
	public function testISameColor_EveryColor_ColorIsRight(): void
	{
		foreach (Color::getAll() as $colorForTile) {
			$tile = new Tile($colorForTile);
			foreach (Color::getAll() as $color) {
				if ($color === $colorForTile) {
					$this->assertTrue($tile->isSameColor($color));
				} else {
					$this->assertFalse($tile->isSameColor($color));
				}
			}
		}
	}
}