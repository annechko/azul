<?php

namespace Azul\Game;

use Azul\Tile\Tile;
use Webmozart\Assert\Assert;

class Table
{
    private $centerPile = [];

    public function addToCenterPile($tiles): void
    {
        if ($tiles instanceof Tile) {
            $tiles = [$tiles];
        }
        Assert::allIsInstanceOf($tiles, Tile::class);
        foreach ($tiles as $tile) {
            $this->centerPile[$tile->getColor()][] = $tile;
        }
    }

    public function getCenterPileCount($color = null): int
    {
        if ($color === null) {
            $count = 0;
            foreach ($this->centerPile as $tiles) {
                $count += count($tiles);
            }
            return $count;
        }
        return count($this->centerPile[$color] ?? []);
    }
}