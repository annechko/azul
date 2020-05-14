<?php

declare(strict_types=1);

namespace Azul\Board;

use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Board
{
	public const ROW_1 = 1;
	public const ROW_2 = 2;
	public const ROW_3 = 3;
	public const ROW_4 = 4;
	public const ROW_5 = 5;

	private BoardWall $wall;
	private TileCollection $floorLine;

	private BoardRow $row1;
	private BoardRow $row2;
	private BoardRow $row3;
	private BoardRow $row4;
	private BoardRow $row5;

	public function __construct(?BoardWall $wall = null)
	{
		$this->wall = $wall ?? new BoardWall();
		$this->row1 = new BoardRow(1);
		$this->row2 = new BoardRow(2);
		$this->row3 = new BoardRow(3);
		$this->row4 = new BoardRow(4);
		$this->row5 = new BoardRow(5);
		$this->floorLine = new TileCollection();
	}

	public function placeTiles(TileCollection $tiles, $rowOrNumber): void
	{
		$row = $rowOrNumber instanceof BoardRow ? $rowOrNumber : $this->getRow($rowOrNumber);
		if ($tiles->top()->isFirstPlayerMarker()) {
			$this->placeOnFloor($tiles->pop());
		}
		$extraCount = $tiles->count() - $row->getEmptySlotsCount();
		for ($j = 0; $j < $extraCount; $j++) {
			$this->placeOnFloor($tiles->pop());
		}
		$row->placeTiles($tiles);
	}

	private function getRow(int $rowNumber): BoardRow
	{
		Assert::range($rowNumber, 1, 5);
		switch ($rowNumber) {
			case 1:
				return $this->row1;
			case 2:
				return $this->row2;
			case 3:
				return $this->row3;
			case 4:
				return $this->row4;
			case 5:
				return $this->row5;
		}
	}

	public function getFloorTilesCount(): int
	{
		return $this->floorLine->count();
	}

	public function getRowTilesCount(int $rowNumber): int
	{
		$row = $this->getRow($rowNumber);
		return $row->getTilesCount();
	}

	/**
	 * @return BoardRow[]
	 */
	public function getRows(): array
	{
		return [
			$this->row1,
			$this->row2,
			$this->row3,
			$this->row4,
			$this->row5,
		];
	}

	public function doWallTiling(): void
	{
		foreach ($this->getRows() as $row) {
			if ($row->isCompleted()) {
				if (!$this->wall->isColorFilledByRow($row)) {
					$this->wall->fillColor($row);
				} else {
					foreach ($row->getTiles() as $tile) {
						$this->placeOnFloor($tile);
					}
				}
			}
		}
	}

	private function placeOnFloor(Tile $tile): void
	{
		$this->floorLine->push($tile);
	}

	public function discardTiles(): TileCollection
	{
		$tiles = new TileCollection();
		foreach ($this->getRows() as $row) {
			foreach ($row->getTiles()->takeAllTiles() as $tile) {
				$tiles->addTile($tile);
			}
		}
		foreach ($this->floorLine->takeAllTiles() as $tile) {
			$tiles->addTile($tile);
		}
		return $tiles;
	}

	public function isAnyWallRowCompleted(): bool
	{
		foreach ($this->getRows() as $row) {
			if ($this->wall->isCompleted($row->getName())) {
				return true;
			}
		}
		return false;
	}
}