<?php

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
                $this->pattern[$rowNumber][$color] = false;
            }
        }
    }

    public function placeTiles(BoardRow $row): void
    {
        if ($this->pattern[$row->getName()][$row->getMainColor()]) {
            throw new BoardWallColorAlreadyFilledException();
        }
        $this->pattern[$row->getName()][$row->getMainColor()] = true;
    }

    public function isCompleted(int $rowNumber): bool
    {
        return !in_array(false, $this->pattern[$rowNumber], true);
    }

    public function isColorFilled(string $color, int $rowNumber): bool
    {
        return $this->pattern[$rowNumber][$color];
    }
}