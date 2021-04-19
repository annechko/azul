<?php

declare(strict_types=1);

namespace Azul\Game;

use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class Bag
{
	private array $tiles = [];
	private array $discardTiles = [];

	public static function create(): self
	{
		$bag = new self();
		foreach (Color::getAll() as $color) {
			$bag->addTiles($color, 20);
		}
		return $bag;
	}

	public function getNextPlate(): TileCollection
	{
		$plateTiles = new TileCollection();
		// TODO check rules - if there are 3 left in bag - game stops?
		if (array_sum($this->tiles) + array_sum($this->discardTiles) >= 4) {
			while ($plateTiles->count() !== 4) {
				$availableColors = array_keys(array_filter(
					$this->tiles,
					static fn ($amount) => $amount > 0
				));
				if (!$availableColors) {
					$this->tiles = $this->discardTiles;
					$this->discardTiles = [];
					continue;
				}
				shuffle($availableColors);
				$randomColor = array_pop($availableColors);
				$this->tiles[$randomColor]--;
				$plateTiles->push(new Tile($randomColor));
			}
		}
		return $plateTiles;
	}

	public function discardTiles(TileCollection $tiles): void
	{
		foreach ($tiles as $tile) {
			$color = $tile->getColor();
			$this->discardTiles[$color] = ($this->discardTiles[$color] ?? 0) + 1;
		}
	}

	public function addTiles(string $color, int $amount): self
	{
		$this->tiles[$color] = ($this->tiles[$color] ?? 0) + $amount;
		return $this;
	}
}
