<?php

namespace Azul\Player\Strategy;

use Azul\Board\Board;
use Azul\Game\FactoryCollection;
use Azul\Game\Table;

abstract class AbstractStrategy
{
	protected Board $board;

	public function __construct(Board $board)
	{
		$this->board = $board;
	}

	abstract public function act(FactoryCollection $factories, Table $table): void;
}