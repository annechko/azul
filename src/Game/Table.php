<?php

namespace Azul\Game;

use Azul\Game\Exception\MarkerAlreadyTakenException;
use Azul\Game\Exception\MarkerCanNotBeTakenException;
use Azul\Game\Exception\MarkerShouldHaveBeenTakenException;
use Azul\Tile\Tile;
use Webmozart\Assert\Assert;

class Table
{
    private $centerPile = [];
    /** @var bool */
    private $markerOnTable;
    /** @var bool */
    private $shouldMarkerBeTaken;

    public function __construct()
    {
        $this->markerOnTable = true;
        $this->shouldMarkerBeTaken = false;
    }

    public function addToCenterPile($tiles): void
    {
        if ($tiles instanceof Tile) {
            $tiles = [$tiles];
        }
        Assert::allIsInstanceOf($tiles, Tile::class);
        foreach ($tiles as $tile) {
            $this->centerPile[$tile->getColor()][] = $tile;
        }
    }

    public function getCenterPileCount($color = null): int
    {
        if ($color === null) {
            $count = 0;
            foreach ($this->centerPile as $tiles) {
                $count += count($tiles);
            }
            return $count;
        }
        return count($this->centerPile[$color] ?? []);
    }

    public function hasStartingPlayerMarker(): bool
    {
        return $this->markerOnTable;
    }

    public function take(string $color): array
    {
        Assert::notEmpty($this->centerPile[$color]);
        if ($this->markerOnTable) {
            if ($this->shouldMarkerBeTaken) {
                throw new MarkerShouldHaveBeenTakenException();
            }
            $this->shouldMarkerBeTaken = true;
        }
        $tiles = $this->centerPile[$color];
        unset($this->centerPile[$color]);
        return $tiles;
    }

    public function takeMarker(): void
    {
        if (!$this->markerOnTable) {
            throw new MarkerAlreadyTakenException();
        }

        if (!$this->shouldMarkerBeTaken) {
            throw new MarkerCanNotBeTakenException();
        }

        $this->markerOnTable = false;
        $this->shouldMarkerBeTaken = false;
    }
}