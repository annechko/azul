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

    public static function createRed(): self
    {
        return new self(COLOR::RED);
    }

    public static function createBlack(): self
    {
        return new self(COLOR::BLACK);
    }

    public static function createBlue(): self
    {
        return new self(COLOR::BLUE);
    }

    public static function createYellow(): self
    {
        return new self(COLOR::YELLOW);
    }

    public static function createCyan(): self
    {
        return new self(COLOR::CYAN);
    }

    public function isSameColor(string $color): bool
    {
        return $this->color === $color;
    }
}
