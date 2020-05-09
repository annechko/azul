<?php

namespace Azul\Game;

use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Factory
{
    /** @var Tile[] */
    private $tiles;
    /** @var Table */
    private $table;

    public function __construct(Table $table, TileCollection $tiles)
    {
        Assert::count($tiles, 4);
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
        $this->tiles = [];
        return $tilesByColor;
    }

    public function getTilesCount(): int
    {
        return count($this->tiles);
    }
}