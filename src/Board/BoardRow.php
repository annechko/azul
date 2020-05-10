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

    public function addTiles(TileCollection $tiles): void
    {
        if ($this->tiles->count() + $tiles->count() > $this->maxTiles) {
            throw new BoardRowSizeExceededException();
        }
        foreach ($tiles as $tile) {
            $this->addTile($tile);
        }
    }

    public function addTile(Tile $tile): void
    {
        if ($this->tiles->count() + 1 > $this->maxTiles) {
            throw new BoardRowSizeExceededException();
        }
        if ($this->tiles->count() > 0 && !$this->tiles->bottom()->isSameColor($tile->getColor())) {
            throw new BoardRowVariousColorsException();
        }
        $this->tiles->push($tile);
    }

    public function getEmptySlotsCount(): int
    {
        return $this->maxTiles - $this->tiles->count();
    }

    public function getTilesCount(): int
    {
        return $this->tiles->count();
    }
}