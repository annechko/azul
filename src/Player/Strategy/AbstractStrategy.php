<?php

namespace Azul\Player\Strategy;

use Azul\Board\Board;
use Azul\Game\FactoryCollection;
use Azul\Game\Table;
use Azul\Player\Move;

abstract class AbstractStrategy
{
	protected Board $board;

	public function __construct(Board $board)
	{
		$this->board = $board;
	}

	abstract public function getNextMove(FactoryCollection $factories, Table $table): ?Move;
}