<?php

namespace Azul\Game;

use Azul\Tile\TileCollection;

interface ITileStorage
{
    public function take(string $color): TileCollection;
    public function getTilesCount(?string $color = null): int;
}