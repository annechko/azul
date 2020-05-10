<?php

namespace Tests;

use Azul\Game\Factory;
use Azul\Game\GameRound;
use Azul\Tile\Color;
use Azul\Tile\Tile;
use Azul\Tile\TileCollection;

class GameRoundTest extends BaseUnit
{
    public function testKeepPlaying_EmptyFactoriesAndTable_False()
    {
        $t = $this->tester->createGameTable();
        $round = new GameRound($t,
            [
                $f = new Factory($t,
                    new TileCollection([
                        new Tile(Color::CYAN),
                        new Tile(Color::CYAN),
                        new Tile(Color::CYAN),
                        new Tile(Color::CYAN),
                    ])
                ),
            ]
        );
        $this->assertTrue($round->canContinue());
        $f->take(Color::CYAN);
        $this->assertFalse($round->canContinue());
    }
}