<?php

namespace Tests;

use Azul\Game\Factory;
use Azul\Player\Player;
use Azul\Board\Board;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class PlayerTest extends BaseUnit
{
    public function testAct_TiledFactoryEmptyTable_IncreaseBoardTilesByFactory()
    {
        $player = new Player($board = new Board());
        $t = $this->tester->createGameTable();
        $factory = new Factory($t, new TileCollection([new Tile(Color::BLUE),]));
        foreach ($board->getRows() as $row) {
            $this->assertEquals(0, $row->getTilesCount());
        }

        $player->act([$factory], $t);

        $counts = [];
        foreach ($board->getRows() as $row) {
            $counts[] = $row->getTilesCount();
        }
        $this->assertContains(1, $counts);
        $this->assertEquals(0, $factory->getTilesCount());
    }

    public function testAct_EmptyFactoryTiledTable_IncreaseBoardTilesByTable()
    {
        $player = new Player($board = new Board());
        $t = $this->tester->createGameTable();
        $t->addToCenterPile(new TileCollection([new Tile(Color::BLUE),]));

        foreach ($board->getRows() as $row) {
            $this->assertEquals(0, $row->getTilesCount());
        }

        $player->act([new Factory($t, new TileCollection())], $t);

        $counts = [];
        foreach ($board->getRows() as $row) {
            $counts[] = $row->getTilesCount();
        }
        $this->assertContains(1, $counts);
        $this->assertEquals(0, $t->getTilesCount());
    }
}