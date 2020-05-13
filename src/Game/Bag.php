<?php
declare(strict_types=1);

namespace Azul\Game;

use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Bag
{
    /** @var TileCollection */
    private $tiles;
    /** @var TileCollection */
    private $discardTiles;

    public function __construct(TileCollection $tiles)
    {
        Assert::range(count($tiles), 0, 100);
        $this->refill($tiles);
        $this->discardTiles = new TileCollection();
    }

    public function getNextPlate(): TileCollection
    {
        $plateTiles = new TileCollection();
        if ($this->tiles->count() + $this->discardTiles->count() >= 4) {
            while ($plateTiles->count() !== 4) {
                if ($this->tiles->count() > 0) {
                    $plateTiles->push($this->tiles->pop());
                } else {
                    $this->refill($this->discardTiles);
                }
            }
        }

        return $plateTiles->count() === 4 ? $plateTiles : new TileCollection();
    }

    public function discardTiles(TileCollection $tiles): void
    {
        foreach ($tiles as $tile) {
            $this->discardTiles->addTile($tile);
        }
    }

    private function refill(TileCollection $tiles): void
    {
        $this->tiles = $tiles;
        $this->shuffleTiles();
    }

    private function shuffleTiles(): void
    {
        $shuffledTiles = new TileCollection();
        $tiles = [];
        foreach ($this->tiles as $tile) {
            $tiles[] = $tile;
        }
        shuffle($tiles);
        foreach ($tiles as $shuffledTile) {
            $shuffledTiles->push($shuffledTile);
        }
        $this->tiles = $shuffledTiles;
    }
}
