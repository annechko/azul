<?php

namespace Azul\Player\Strategy;

use Azul\Board\Board;
use Azul\Game\FactoryCollection;
use Azul\Game\Table;
use Azul\Player\Move;
use Azul\Tile\Color;

class FastestGameStrategy extends AbstractStrategy
{
	public function getNextMove(FactoryCollection $factories, Table $table): ?Move
	{
		foreach ($this->board->getRows() as $row) {
			if ($row->getTilesCount() === 0) {
				# row is empty, get any color that is not on the wall
				foreach ($this->getColors() as $color) {
					if ($this->board->isWallColorFilled($color, $row->getRowNumber())) {
						continue;
					}
					# look for this color by factories, take it from anywhere
					foreach ($factories as $factory) {
						if ($factory->getTilesCount($color) === 0) {
							continue;
						}
						return new Move($color, $row->getRowNumber(), $factory);
					}
					if ($table->getTilesCount($color)) {
						return new Move($color, $row->getRowNumber(), $table);
					}
				}
			} else {
				if ($row->getEmptySlotsCount() > 0) {
					# row already got tiles, look for the same color anywhere
					$color = $row->getMainColor();
					foreach ($factories as $factory) {
						if ($factory->getTilesCount($color) === 0) {
							continue;
						}
						return new Move($color, $row->getRowNumber(), $factory);
					}
					# no needed tiles on factories, check table for this color
					if ($table->getTilesCount($color)) {
						return new Move($color, $row->getRowNumber(), $table);
					}
				}
			}
		}

		foreach ($factories as $factory) {
			foreach ($this->getColors() as $color) {
				if ($factory->getTilesCount($color) > 0) {
					return new Move($color, Board::ROW_1, $factory);
				} else {
					if ($table->getTilesCount($color) > 0) {
						return new Move($color, Board::ROW_1, $table);
					}
				}
			}
		}
		return null;
	}

	private function getColors(): array
	{
		$colors = Color::getAll();
		shuffle($colors);
		return $colors;
	}
}