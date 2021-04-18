<?php

declare(strict_types=1);

namespace Azul\Player;

use Azul\Game\ITileStorage;
use Azul\Game\Table;

class Move
{
	private string $color;
	private int $rowNumber;
	private ITileStorage $storage;
	private bool $isFromTable;

	public function __construct(
		string $color,
		int $rowNumber,
		ITileStorage $storage
	) {
		$this->color = $color;
		$this->rowNumber = $rowNumber;
		$this->storage = $storage;
		// TODO instanceof is not a nice solution
		$this->isFromTable = $this->storage instanceof Table;
	}

	public function getColor(): string
	{
		return $this->color;
	}

	public function getRowNumber(): int
	{
		return $this->rowNumber;
	}

	public function getStorage(): ITileStorage
	{
		return $this->storage;
	}

	public function isFromTable(): bool
	{
		return $this->isFromTable;
	}
}