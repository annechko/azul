<?php

namespace Azul\Tile;

class TileFactory
{
    public function createGameTiles(): TileCollection
    {
        $tiles = new TileCollection();
        for ($i = 0; $i < 20; $i++) {
            $tiles->addTile(Tile::createBlack());
            $tiles->addTile(Tile::createBlue());
            $tiles->addTile(Tile::createCyan());
            $tiles->addTile(Tile::createRed());
            $tiles->addTile(Tile::createYellow());
        }
        return $tiles;
    }
}
