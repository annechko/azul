<?php

namespace Azul\Tile;

class TileFactory
{
    public function createGameTiles(): TileCollection
    {
        $tiles = new TileCollection();
        for ($i = 0; $i < 20; $i++) {
            $tiles->addTile(new Tile(Color::BLACK));
            $tiles->addTile(new Tile(Color::BLUE));
            $tiles->addTile(new Tile(Color::CYAN));
            $tiles->addTile(new Tile(Color::RED));
            $tiles->addTile(new Tile(Color::YELLOW));
        }
        return $tiles;
    }
}
