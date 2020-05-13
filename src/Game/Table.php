<?php

declare(strict_types=1);

namespace Azul\Game;

use Azul\Tile\Marker;
use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Table implements ITileStorage
{
	private array $centerPile = [];
	private ?Marker $marker;

	public function __construct(?Marker $marker)
	{
		$this->marker = $marker;
	}

	public function addToCenterPile(TileCollection $tiles): void
	{
		foreach ($tiles as $tile) {
			$this->centerPile[$tile->getColor()][] = $tile;
		}
	}

	public function getTilesCount(?string $color = null): int
	{
		if ($color === null) {
			$count = 0;
			foreach ($this->centerPile as $tiles) {
				$count += count($tiles);
			}
			return $count;
		}
		return count($this->centerPile[$color] ?? []);
	}

	public function take(string $color): TileCollection
	{
		Assert::notEmpty($this->centerPile[$color]);
		$tiles = new TileCollection($this->centerPile[$color]);
		if ($this->marker) {
			$tiles[] = $this->marker;
			$this->marker = null;
		}
		unset($this->centerPile[$color]);
		return $tiles;
	}
}