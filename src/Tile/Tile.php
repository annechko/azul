<?php

namespace Azul\Tile;

class Tile
{
    private const RED = 'red';
    private const CYAN = 'cyan';
    private const BLACK = 'black';
    private const BLUE = 'blue';
    private const YELLOW = 'yellow';
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
        return new self(self::RED);
    }

    public static function createBlack(): self
    {
        return new self(self::BLACK);
    }

    public static function createBlue(): self
    {
        return new self(self::BLUE);
    }

    public static function createYellow(): self
    {
        return new self(self::YELLOW);
    }

    public static function createCyan(): self
    {
        return new self(self::CYAN);
    }

    public function isRed(): bool
    {
        return $this->color === self::RED;
    }

    public function isBlue(): bool
    {
        return $this->color === self::BLUE;
    }

    public function isBlack(): bool
    {
        return $this->color === self::BLACK;
    }

    public function isYellow(): bool
    {
        return $this->color === self::YELLOW;
    }

    public function isCyan(): bool
    {
        return $this->color === self::CYAN;
    }
}
