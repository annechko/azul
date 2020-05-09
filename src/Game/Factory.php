<?php

namespace Azul\Game;

use Azul\Tile\Tile;
use Webmozart\Assert\Assert;

class Factory
{
    /** @var Tile[] */
    private $tiles;
    /** @var Table */
    private $table;

    /**
     * @param Table $table
     * @param Tile[] $tiles
     */
    public function __construct(Table $table, $tiles)
    {
        Assert::count($tiles, 4);
        Assert::allIsInstanceOf($tiles, Tile::class);
        $this->table = $table;
        $this->tiles = $tiles;
    }

    public function take(string $color): array
    {
        $tilesByColor = [];
        $tilesToTable = [];
        foreach ($this->tiles as $index => $tile) {
            if ($tile->isSameColor($color)) {
                $tilesByColor[] = $tile;
            } else {
                $tilesToTable[] = $tile;
            }
        }
        Assert::minCount($tilesByColor, 1);
        $this->table->addToCenterPile($tilesToTable);
        unset($this->tiles);
        return $tilesByColor;
    }
}