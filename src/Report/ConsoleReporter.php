<?php

declare(strict_types=1);

namespace Azul\Report;

use Azul\Board\Board;
use Azul\Event\PlayerFinishTurnEvent;
use Azul\Event\RoundCreatedEvent;
use Azul\Event\WallTiledEvent;
use Azul\Player\Player;
use Azul\Tile\Color;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConsoleReporter implements EventSubscriberInterface
{
	private OutputInterface $output;

	public function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}

	/** {@inheritdoc} */
	public static function getSubscribedEvents()
	{
		return [
			RoundCreatedEvent::class => 'onRoundCreated',
			PlayerFinishTurnEvent::class => 'onPlayerFinishTurn',
			WallTiledEvent::class => 'onWallTiled',
		];
	}

	public function onRoundCreated(RoundCreatedEvent $event): void
	{
		$this->drawFactories($event->getRound()->getFactories());
		$this->drawTable($event->getRound()->getTable());
	}

	public function onPlayerFinishTurn(PlayerFinishTurnEvent $event): void
	{
		$round = $event->getRound();
		$player = $event->getPlayer();
		$this->writeln('test - onPlayerFinishTurn');
		$this->drawFactories($round->getFactories());
		$this->drawTable($round->getTable());
		$this->drawPlayerBoard($player);
	}

	private function drawPlayerBoard(Player $player): void
	{
		$this->writeln('', false);
		$this->writeln('player ' . $player->getName(), false);

		$this->drawPlayerBoardPatternLines($player->getBoard());
		$this->writeln('', false);

		foreach ($player->getBoard()->getFloorTiles() as $tile) {
			$this->drawTile($tile);
		}
	}

	private function drawPlayerBoardPatternLines(Board $board): void
	{
		foreach ($board->getRows() as $row) {
			foreach ($row->getTiles() as $tile) {
				$this->drawTile($tile);
			}
			for ($j = 0; $j < $row->getEmptySlotsCount(); $j++) {
				$this->write('.', false);
			}
			$this->writeln('', false);
		}
	}

	public function onWallTiled(WallTiledEvent $event): void
	{
		$this->writeln('test - onWallTiled');
	}

	private function writeln(string $message, bool $wait = true): void
	{
		$this->output->writeln($message);
		if ($wait) {
			usleep(1000000 / 2);
		}
	}

	private function write(string $message, $wait = true): void
	{
		$this->output->write($message);
		if ($wait) {
			usleep(1000000 / 2);
		}
	}

	private function getColorSymbol(string $color): string
	{
		switch ($color) {
			case '':
				return '💠';
			case Color::BLACK:
				return '🔳';
			case Color::BLUE:
				return '🟦';
			case Color::CYAN:
				return '🟩';
			case Color::RED:
				return '🟥';
			case Color::YELLOW:
				return '🟨';
		}
	}

	private function drawFactories(\Azul\Game\FactoryCollection $factories): void
	{
		foreach ($factories as $factory) {
			$this->write('_', false);
			foreach ($factory->getTiles() as $tile) {
				$this->drawTile($tile);
			}
			$this->write('_', false);
			$this->write('   ', false);
		}
		$this->writeln('');
	}

	private function drawTable(\Azul\Game\Table $table): void
	{
		$this->write('_', false);
		if ($table->getMarker()) {
			$this->drawTile($table->getMarker());
		}
		foreach ($table->getCenterPileTiles() as $color => $tiles) {
			foreach ($tiles as $tile) {
				$this->drawTile($tile);
			}
		}
		$this->write('_', false);
		$this->writeln('');
	}

	private function drawTile(\Azul\Tile\Tile $tile): void
	{
		$this->write($this->getColorSymbol($tile->getColor()), false);
	}
}