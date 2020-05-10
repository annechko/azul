<?php

namespace Azul\Game;

use Azul\Player\PlayerCollection;
use Azul\Tile\Marker;

class Game
{
    private Bag $bag;
    private Marker $marker;
    private ?GameRound $round = null;

    public function __construct(Bag $bag, Marker $marker)
    {
        $this->bag = $bag;
        $this->marker = $marker;
    }

    public function play(PlayerCollection $players): void
    {
        while (true) {
            if (!$this->round) {
                foreach ($players as $player) {
                    if ($player->isGameOver()) {
                        break;
                    }
                }
                $this->round = $this->createRound($players);
            }
            if ($this->round->canContinue()) {
                foreach ($players as $player) {
                    $player->act($this->round->getFactories(), $this->round->getTable());
                }
            } else {
                $this->round = null;
                foreach ($players as $player) {
                    $player->doWallTiling();
                }
            }
        }
    }

    private function createRound(PlayerCollection $players): GameRound
    {
        $table = new Table($this->marker);
        return new GameRound(
            $table,
            [
                new Factory($table, $this->bag->getNextPlate()),
                new Factory($table, $this->bag->getNextPlate()),
                new Factory($table, $this->bag->getNextPlate()),
                new Factory($table, $this->bag->getNextPlate()),
                new Factory($table, $this->bag->getNextPlate()),
            ]
        );
    }
}