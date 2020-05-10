<?php

namespace Azul\Player;

use Azul\Board\Board;
use Azul\Board\BoardRow;
use Azul\Game\Factory;
use Azul\Game\ITileStorage;
use Azul\Game\Table;
use Azul\Tile\Color;

class Player
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * @param Factory[] $factories
     * @param Table $table
     */
    public function act(array $factories, Table $table): void
    {
        foreach (Color::getAll() as $color) {
            foreach ($factories as $factory) {
                $success = $this->tryToTake($factory, $color);
                $success = $success ?: $this->tryToTake($table, $color);
                if ($success) {
                    return;
                }
            }
        }
    }

    private function tryToTake(ITileStorage $storage, string $color): bool
    {
        $count = $storage->getTilesCount($color);
        if ($count > 0) {
            foreach ($this->board->getRows() as $row) {
                /** @var BoardRow $row */
                if ($row->isMainColor($color) && $row->getEmptySlotsCount() > 0) {
                    $this->board->placeTiles($storage->take($color), $row);
                    return true;
                }
                if ($row->getTilesCount() === 0) {
                    $this->board->placeTiles($storage->take($color), $row);
                    return true;
                }
            }
        }
        return false;
    }

    public function doWallTiling(): void
    {

    }

    public function isGameOver(): bool
    {
        return false;
    }
}