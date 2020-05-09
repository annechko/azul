<?php

namespace Azul\Tile;

class Tile
{
    /** @var string */
    private $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function isSameColor(string $color): bool
    {
        return $this->color === $color;
    }

    public function isFirstPlayerMarker(): bool
    {
        return false;
    }
}
