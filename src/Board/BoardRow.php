<?php

namespace Azul\Board;

use Azul\Board\Exception\BoardRowSizeExceededException;
use Azul\Board\Exception\BoardRowVariousColorsException;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class BoardRow
{
    private int $maxTiles;
    private TileCollection $tiles;

    public function __construct(int $maxTiles)
    {
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
}