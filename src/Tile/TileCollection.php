<?php

namespace Azul\Tile;

/**
 * @method Tile current()
 * @method Tile bottom()
 * @method Tile top()
 */
class TileCollection extends \SplStack
{
    public function __construct($tiles = [])
    {
        foreach ($tiles as $tile) {
            $this->addTile($tile);
        }
    }

    public function addTile(Tile $tile): void
    {
        $this->push($tile);
    }
}
