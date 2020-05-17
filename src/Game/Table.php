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
			if (!array_key_exists($tile->getColor(), $this->centerPile)) {
				$this->centerPile[$tile->getColor()] = new TileCollection();
			}
			$this->centerPile[$tile->getColor()]->addTile($tile);
		}
	}

	public function getTilesCount(?string $color = null): int
	{
		if ($color === null) {
			$count = 0;
			foreach ($this->centerPile as $tiles) {
				$count += $tiles->count();
			}
			return $count;
		}
		return array_key_exists($color, $this->centerPile) ? $this->centerPile[$color]->count() : 0;
	}

	public function take(string $color): TileCollection
	{
		Assert::notEmpty($this->centerPile[$color]);
		$tiles = $this->centerPile[$color]->takeAllTiles();
		if ($this->marker) {
			$tiles->addTile($this->marker);
			$this->marker = null;
		}
		unset($this->centerPile[$color]);
		return $tiles;
	}

	public function getCenterPileTiles(): array
	{
		return $this->centerPile;
	}

	public function getMarker(): ?Marker
	{
		return $this->marker;
	}
}