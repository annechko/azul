<?php

namespace Azul\Game;

use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Factory
{
    /** @var Tile[] */
    private TileCollection $tiles;
    private Table $table;

    public function __construct(Table $table, TileCollection $tiles)
    {
        $this->table = $table;
        $this->tiles = $tiles;
    }

    public function take(string $color): TileCollection
    {
        $tilesByColor = new TileCollection();
        $tilesToTable = new TileCollection();
        foreach ($this->tiles as $index => $tile) {
            if ($tile->isSameColor($color)) {
                $tilesByColor[] = $tile;
            } else {
                $tilesToTable[] = $tile;
            }
        }
        Assert::minCount($tilesByColor, 1);
        $this->table->addToCenterPile($tilesToTable);
        $this->tiles = new TileCollection();
        return $tilesByColor;
    }

    public function getTilesCount(?string $color = null): int
    {
        if ($color === null) {
            return count($this->tiles);
        }
        $c = 0;
        foreach ($this->tiles as $tile) {
            if ($tile->isSameColor($color)) {
                $c++;
            }
        }
        return $c;
    }
}