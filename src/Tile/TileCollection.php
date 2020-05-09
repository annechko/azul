<?php

namespace Azul\Tile;

class TileCollection extends \SplStack
{
    public function addTile(Tile $tile): void
    {
        $this->push($tile);
    }
}
