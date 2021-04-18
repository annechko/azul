<?php

declare(strict_types=1);

namespace Azul\Game;

use Azul\Game\Exception\MarkerAlreadyTakenException;
use Azul\Tile\Marker;
use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Table implements ITileStorage
{
	private array $centerPile = [];
	private ?Marker $marker;

	public function __construct(?Marker $marker = null)
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

	public function hasMarker(): bool
	{
		return $this->getMarker() !== null;
	}

	public function takeMarker(): Marker
	{
		// TODO marker doesn't have to be singleton, can create new obj here?
		$marker = $this->marker;
		if (!$marker) {
			throw new MarkerAlreadyTakenException();
		}
		$this->marker = null;
		return $marker;
	}
}