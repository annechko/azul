<?php

namespace Tests;

use Azul\Game\Bag;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;
use Azul\Tile\TileFactory;

class BagTest extends \Codeception\Test\Unit
{
    public function testGetNext_NoTiles_NoNext()
    {
        $bag = new Bag(new TileCollection());
        $this->assertEmpty($bag->getNextPlate());
    }

    public function testNextPlate_GameTiles_Get4Tiles()
    {
        $tiles = (new TileFactory)->createGameTiles();
        $bag = new Bag($tiles);
        $this->assertCount(4, $bag->getNextPlate());
    }

    public function testNextPlate_5Tiles_Get4TilesOnce()
    {
        $tiles = new TileCollection();
        for ($j = 0; $j < 5; $j++) {
            $tiles->addTile(Tile::createBlack());
        }
        $bag = new Bag($tiles);
        $this->assertCount(4, $bag->getNextPlate());
        $this->assertCount(0, $bag->getNextPlate());
    }

    public function testNextPlate_5TilesRefill4_Get4TilesTwice()
    {
        $tiles = new TileCollection();
        for ($j = 0; $j < 5; $j++) {
            $tiles->addTile(Tile::createBlack());
        }
        $bag = new Bag($tiles);
        $this->assertCount(4, $firstPlate = $bag->getNextPlate());
        $bag->discardTiles($firstPlate);
        $this->assertCount(4, $bag->getNextPlate());
    }

    public function testNextPlate_SameTiles_VariousPlatesAfterRefill()
    {
        $tilesFirst = new TileCollection();
        $tilesSecond = new TileCollection();
        for ($j = 0; $j < 4; $j++) {
            $tilesFirst->addTile(Tile::createBlack());
            $tilesFirst->addTile(Tile::createCyan());
            $tilesFirst->addTile(Tile::createRed());

            $tilesSecond->addTile(Tile::createBlack());
            $tilesSecond->addTile(Tile::createCyan());
            $tilesSecond->addTile(Tile::createRed());
        }
        $bag = new Bag(new TileCollection());
        $bag->discardTiles($tilesSecond);
        $firstHashes[] = $this->createPlateHashes($bag->getNextPlate());
        $firstHashes[] = $this->createPlateHashes($bag->getNextPlate());
        $firstHashes[] = $this->createPlateHashes($bag->getNextPlate());
        $bag->discardTiles($tilesSecond);
        $secondHashes[] = $this->createPlateHashes($bag->getNextPlate());
        $secondHashes[] = $this->createPlateHashes($bag->getNextPlate());
        $secondHashes[] = $this->createPlateHashes($bag->getNextPlate());
        $this->assertNotEquals(($firstHashes), ($secondHashes));
    }

    private function createPlateHashes(TileCollection $tiles)
    {
        $hash = '';
        foreach ($tiles as $tile) {
            $hash .= $tile->getColor();
        }
        return $hash;
    }
}