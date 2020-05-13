<?php

declare(strict_types=1);

namespace Azul\Board;

use Azul\Board\Exception\BoardRowSizeExceededException;
use Azul\Board\Exception\BoardRowVariousColorsException;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class BoardRow
{
	private int $maxTiles;
	private TileCollection $tiles;

	public function __construct(int $maxTiles)
	{
		Assert::range($maxTiles, 1, 5);
		$this->maxTiles = $maxTiles;
		$this->tiles = new TileCollection();
	}

	public function placeTiles(TileCollection $tiles): void
	{
		if ($this->getTilesCount() + $tiles->count() > $this->maxTiles) {
			throw new BoardRowSizeExceededException();
		}
		foreach ($tiles as $tile) {
			$this->addTile($tile);
		}
	}

	public function addTile(Tile $tile): void
	{
		if ($this->getTilesCount() + 1 > $this->maxTiles) {
			throw new BoardRowSizeExceededException();
		}
		if ($this->getTilesCount() > 0 && !$this->isMainColor($tile->getColor())) {
			throw new BoardRowVariousColorsException();
		}
		$this->tiles->push($tile);
	}

	public function getMainColor(): string
	{
		return $this->getTilesCount() ? $this->tiles->bottom()->getColor() : '';
	}

	public function isMainColor(string $color): bool
	{
		return $this->getTilesCount() === 0 ? true : $this->getMainColor() === $color;
	}

	public function getEmptySlotsCount(): int
	{
		return $this->maxTiles - $this->getTilesCount();
	}

	public function getTilesCount(): int
	{
		return $this->tiles->count();
	}

	public function getName(): int
	{
		switch ($this->maxTiles) {
			case 1:
				return Board::ROW_1;
			case 2:
				return Board::ROW_2;
			case 3:
				return Board::ROW_3;
			case 4:
				return Board::ROW_4;
			case 5:
				return Board::ROW_5;
		}
	}

	public function isCompleted(): bool
	{
		return $this->getTilesCount() === $this->maxTiles;
	}

	public function getTiles(): TileCollection
	{
		return $this->tiles;
	}
}