<?php
declare(strict_types=1);

namespace Azul\Player;

use Azul\Board\Board;
use Azul\Board\BoardRow;
use Azul\Game\Factory;
use Azul\Game\ITileStorage;
use Azul\Game\Table;
use Azul\Tile\Color;
use Azul\Tile\TileCollection;

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
        foreach ([false, true] as $force) {
            foreach (Color::getAll() as $color) {
                foreach ($factories as $factory) {
                    $success = $this->tryToTake($factory, $color, $force);
                    $success = $success ?: $this->tryToTake($table, $color, $force);
                    if ($success) {
                        return;
                    }
                }
            }
        }
    }

    private function tryToTake(ITileStorage $storage, string $color, bool $force = false): bool
    {
        $count = $storage->getTilesCount($color);
        if ($count > 0) {
            if ($force) {
                $this->board->placeTiles($storage->take($color), Board::ROW_1);
                return true;
            }
            foreach ($this->board->getRows() as $row) {
                /** @var BoardRow $row */
                if ($row->isMainColor($color) && $row->getEmptySlotsCount() > 0) {
                    $this->board->placeTiles($storage->take($color), $row);
                    return true;
                }
            }
        }
        return false;
    }

    public function doWallTiling(): void
    {
        $this->board->doWallTiling();
    }

    public function isGameOver(): bool
    {
        return false;
    }

    public function getDiscardedTiles(): TileCollection
    {
        return $this->board->discardTiles();
    }
}