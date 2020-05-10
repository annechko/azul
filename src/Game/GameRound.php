<?php

namespace Azul\Game;

use Webmozart\Assert\Assert;

class GameRound
{
    /** @var Factory[] */
    private $factories;
    /** @var Table */
    private $table;

    public function __construct(?Table $table, array $factories)
    {
        Assert::allIsInstanceOf($factories, Factory::class);
        $this->table = $table;
        $this->factories = $factories;
    }

    public function canContinue(): bool
    {
        $factoriesTileCount = 0;
        foreach ($this->factories as $factory) {
            $factoriesTileCount += $factory->getTilesCount();
        }
        return $this->table->getCenterPileCount() > 0 || $factoriesTileCount > 0;
    }

    public function getFactories(): array
    {
        return $this->factories;
    }

    public function getTable(): Table
    {
        return $this->table;
    }
}