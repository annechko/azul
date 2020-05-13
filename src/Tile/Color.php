<?php

declare(strict_types=1);

namespace Azul\Tile;

class Color
{
	public const BLACK = 'black';
	public const BLUE = 'blue';
	public const CYAN = 'cyan';
	public const RED = 'red';
	public const YELLOW = 'yellow';

	public static function getAll(): array
	{
		return [
			self::BLACK,
			self::BLUE,
			self::CYAN,
			self::RED,
			self::YELLOW,
		];
	}
}