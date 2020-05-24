<?php

declare(strict_types=1);

namespace Azul\Board;

use Azul\Board\Exception\BoardWallColorAlreadyFilledException;
use Azul\Tile\Color;

class BoardWall
{
	private const PATTERN = [
		Board::ROW_1 => [
			Color::BLUE,
			Color::YELLOW,
			Color::RED,
			Color::BLACK,
			Color::CYAN,
		],
		Board::ROW_2 => [
			Color::CYAN,
			Color::BLUE,
			Color::YELLOW,
			Color::RED,
			Color::BLACK,
		],
		Board::ROW_3 => [
			Color::BLACK,
			Color::CYAN,
			Color::BLUE,
			Color::YELLOW,
			Color::RED,
		],
		Board::ROW_4 => [
			Color::RED,
			Color::BLACK,
			Color::CYAN,
			Color::BLUE,
			Color::YELLOW,
		],
		Board::ROW_5 => [
			Color::YELLOW,
			Color::RED,
			Color::BLACK,
			Color::CYAN,
			Color::BLUE,
		],
	];
	private array $pattern;

	public function __construct()
	{
		$this->pattern = [];
		foreach (self::PATTERN as $rowNumber => $rowColors) {
			foreach ($rowColors as $color) {
				$this->pattern[$rowNumber][$color] = null;
			}
		}
	}

	public function fillColor(BoardRow $row): void
	{
		if ($this->isColorFilledByRow($row)) {
			throw new BoardWallColorAlreadyFilledException();
		}
		$this->pattern[$row->getName()][$row->getMainColor()] = $row->getTileForWall();
	}

	public function isCompleted(int $rowNumber): bool
	{
		return !in_array(null, $this->pattern[$rowNumber], true);
	}

	public function isColorFilled(string $color, int $row): bool
	{
		return $this->pattern[$row][$color] !== null;
	}

	public function isColorFilledByRow(BoardRow $row): bool
	{
		return $this->isColorFilled($row->getMainColor(), $row->getName());
	}

	public function getPattern(BoardRow $row): array
	{
		return $this->pattern[$row->getName()];
	}
}