<?php

declare(strict_types=1);

namespace Azul\Game;

class GameRound
{
	private FactoryCollection $factories;
	private Table $table;

	public function __construct(Table $table, array $factories)
	{
		$this->table = $table;
		$this->factories = new FactoryCollection($factories);
	}

	public function canContinue(): bool
	{
		$factoriesTileCount = 0;
		foreach ($this->factories as $factory) {
			$factoriesTileCount += $factory->getTilesCount();
		}
		return $this->table->getTilesCount() > 0 || $factoriesTileCount > 0;
	}

	public function getFactories(): FactoryCollection
	{
		return $this->factories;
	}

	public function getTable(): Table
	{
		return $this->table;
	}
}