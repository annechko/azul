<?php

declare(strict_types=1);

namespace Azul\Player;

use Azul\Board\Board;
use Azul\Game\FactoryCollection;
use Azul\Game\Table;
use Azul\Player\Strategy\AbstractStrategy;
use Azul\Player\Strategy\FastestGameStrategy;
use Azul\Tile\TileCollection;

class Player
{
	private Board $board;
	private string $name;
	private AbstractStrategy $gameStrategy;

	public function __construct(Board $board, string $name = '')
	{
		$this->board = $board;
		$this->name = $name;
		$this->gameStrategy = new FastestGameStrategy($this->board);
	}

	public function getNextMove(FactoryCollection $factories, Table $table): ?Move
	{
		return $this->gameStrategy->getNextMove($factories, $table);
	}

	public function doWallTiling(): void
	{
		$this->board->doWallTiling();
	}

	public function isGameOver(): bool
	{
		return $this->board->isAnyWallRowCompleted();
	}

	public function discardTiles(): TileCollection
	{
		return $this->board->discardTiles();
	}

	public function getBoard(): Board
	{
		return $this->board;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function takeMarker(\Azul\Tile\Marker $marker): void
	{
		$this->board->placeMarker($marker);
	}

	public function placeTiles(TileCollection $tiles, int $rowNumber): void
	{
		$this->board->placeTiles($tiles, $rowNumber);
	}
}