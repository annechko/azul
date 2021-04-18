<?php

declare(strict_types=1);

namespace Azul\Game;

use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Factory implements ITileStorage
{
	private TileCollection $tiles;

	public function __construct(TileCollection $tiles)
	{
		$this->tiles = $tiles;
	}

	public function takeAll(): TileCollection
	{
		$tiles = $this->tiles;
		$this->tiles = new TileCollection();
		return $tiles;
	}

	public function take(string $color): TileCollection
	{
		$tilesByColor = new TileCollection();
		$tilesLeft = new TileCollection();
		// TODO probably tile collection should not be list -_-
		foreach ($this->tiles as $tile) {
			if ($tile->isSameColor($color)) {
				$tilesByColor[] = $tile;
			} else {
				$tilesLeft[] = $tile;
			}
		}
		Assert::minCount($tilesByColor, 1);
		// TODO either do everything only with asserts or only with exceptions
		$this->tiles = new TileCollection($tilesLeft);
		return $tilesByColor;
	}

	public function getTilesCount(?string $color = null): int
	{
		if ($color === null) {
			return count($this->tiles);
		}
		$c = 0;
		foreach ($this->tiles as $tile) {
			if ($tile->isSameColor($color)) {
				$c++;
			}
		}
		return $c;
	}

	public function getTiles(): TileCollection
	{
		return $this->tiles;
	}
}