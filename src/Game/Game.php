<?php

namespace Azul\Game;

use Azul\Player\PlayerCollection;
use Azul\Tile\Marker;
use Azul\Tile\TileFactory;

class Game
{
    private bool $isOver;
    private GameRound $round;
    private Marker $marker;

    public function __construct(Bag $bag, Marker $marker)
    {
        $this->bag = $bag;
        $this->marker = $marker;
    }

    public function play(PlayerCollection $players)
    {
        while ($this->canContinue()) {
            if (!$this->round) {
                $this->round = $this->createRound($players);
            }
            if ($this->round->canContinue()) {
                foreach ($players as $player) {
                    $player->act($this->round->getFactories(), $this->round->getTable());
                }
            }
        }
    }

    private function setIsOver(bool $isOver): void
    {
        $this->isOver = $isOver;
    }

    private function canContinue(): bool
    {
        return !$this->isOver;
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