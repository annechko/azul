<?php
declare(strict_types=1);

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
        if ($tiles instanceof Tile) {
            $tiles = [$tiles];
        }
        foreach ($tiles as $tile) {
            $this->addTile($tile);
        }
    }

    public function addTile(Tile $tile): void
    {
        $this->push($tile);
    }

    public function takeAllTiles(): TileCollection
    {
        $tiles = new TileCollection();
        while ($this->count() > 0 && $tile = $this->pop()) {
            $tiles->push($tile);
        }
        return $tiles;
    }
}
