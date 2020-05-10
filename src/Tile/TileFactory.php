<?php

namespace Azul\Tile;

class TileFactory
{
    public function createGameTiles(): TileCollection
    {
        $tiles = new TileCollection();
        for ($i = 0; $i < 20; $i++) {
            foreach (Color::getAll() as $color) {
                $tiles->addTile(new Tile($color));
            }
        }
        return $tiles;
    }
}
