<?php

namespace Azul\Player\Strategy;

use Azul\Board\Board;
use Azul\Board\BoardRow;
use Azul\Game\FactoryCollection;
use Azul\Game\ITileStorage;
use Azul\Game\Table;
use Azul\Tile\Color;

class FastestGameStrategy extends AbstractStrategy
{
	public function act(FactoryCollection $factories, Table $table): void
	{
		foreach ($factories as $factory) {
			$success = $this->takeIfWallRowEmpty($factory);
			if ($success) {
				return;
			}
		}
		if ($this->takeIfWallRowEmpty($table)) {
			return;
		}

		foreach (Color::getAll() as $color) {
			foreach ($this->board->getRows() as $row) {
				foreach ($factories as $factory) {
					$success = $this->tryToTake($row, $factory, $color, true);
					if ($success) {
						return;
					}
				}
				$success = $this->tryToTake($row, $table, $color, true);
				if ($success) {
					return;
				}
			}
		}
	}

	private function tryToTake(BoardRow $row, ITileStorage $storage, string $color, bool $force = false): bool
	{
		$count = $storage->getTilesCount($color);
		if ($count > 0) {
			if ($force) {
				$this->board->placeTiles($storage->take($color), Board::ROW_1); // so tiles go on floor
				return true;
			}
			if ($row->isMainColor($color) && $row->getEmptySlotsCount() > 0) {
				$this->board->placeTiles($storage->take($color), $row);
				return true;
			}
		}
		return false;
	}

	private function takeIfWallRowEmpty(ITileStorage $storage): bool
	{
		foreach ($this->board->getRows() as $row) {
			foreach (Color::getAll() as $color) {
				if ($this->board->isWallColorFilled($color, $row->getRowNumber())) {
					continue;
				}
				$success = $this->tryToTake($row, $storage, $color);
				if ($success) {
					return $success;
				}
			}
		}
		return false;
	}
}