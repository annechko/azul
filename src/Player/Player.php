<?php

namespace Azul\Player;

use Azul\Board\Board;
use Azul\Game\Factory;
use Azul\Game\Table;
use Azul\Tile\Color;
use Azul\Tile\TileCollection;

class Player
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * @param Factory[] $factories
     * @param Table $table
     */
    public function act(array $factories, Table $table): void
    {
        foreach ($factories as $factory) {
            foreach (Color::getAll() as $color) {
                $count = $factory->getTilesCount($color);
                if ($count > 0) {
                    for ($j = $count; $j <= 5; $j++) {
                        /** @var TileCollection $row */
                        $row = $this->board->{'row' . $count};
                        if ($row->count() <= $count) {
                            $tiles = $factory->take($color);
                            foreach ($tiles as $tile) {
                                $row->push($tile);
                            }
                            break;
                        }
                    }
                } elseif ($table->getCenterPileCount($color) > 0) {

                }
            }
        }
    }
}