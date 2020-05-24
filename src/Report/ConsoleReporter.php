<?php

declare(strict_types=1);

namespace Azul\Report;

use Azul\Board\Board;
use Azul\Event\PlayerFinishTurnEvent;
use Azul\Event\RoundCreatedEvent;
use Azul\Event\WallTiledEvent;
use Azul\Player\Player;
use Azul\Player\PlayerCollection;
use Azul\Tile\Color;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConsoleReporter implements EventSubscriberInterface
{
	private const EMPTY_SLOT_SIGN = '🖤';
	private OutputInterface $output;
	private \Azul\Game\GameRound $round;
	/** @var Player[] */
	private array $players;

	public function __construct(PlayerCollection $players, OutputInterface $output)
	{
		$this->output = $output;
		foreach ($players as $player) {
			$this->setPlayer($player);
		}
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
		$this->round = $event->getRound();
		$this->drawReport();
	}

	public function onPlayerFinishTurn(PlayerFinishTurnEvent $event): void
	{
		$this->round = $event->getRound();
		$this->setPlayer($event->getPlayer());
		$this->drawReport();
	}

	public function onWallTiled(WallTiledEvent $event): void
	{
		$this->writeln('test - onWallTiled');
	}

	private function drawReport(): void
	{
		static $roundCount = 0;
		$this->drawFactories($this->round->getFactories());
		$this->drawTable($this->round->getTable());
		$this->drawPlayers();
		$this->writeln(str_repeat('_', 35) . ++$roundCount . str_repeat('_', 35));
		$this->wait();
	}

	private function setPlayer(Player $player): void
	{
		$this->players[spl_object_hash($player)] = $player;
	}

	private function writeln(string $message): void
	{
		$this->output->writeln($message);
	}

	private function write(string $message): void
	{
		$this->output->write($message);
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
			$this->write('|_');
			foreach ($factory->getTiles() as $tile) {
				$this->drawTile($tile);
			}
			$this->write(str_repeat('_.', 4 - $factory->getTilesCount()) . '_|');
			$this->write('   ');
		}
		$this->writeln('');
	}

	private function drawTable(\Azul\Game\Table $table): void
	{
		$this->write('table -> _');
		if ($table->getMarker()) {
			$this->drawTile($table->getMarker());
		}
		foreach ($table->getCenterPileTiles() as $color => $tiles) {
			foreach ($tiles as $tile) {
				$this->drawTile($tile);
			}
		}
		$this->write('_');
		$this->writeln('');
	}

	private function drawTile(\Azul\Tile\Tile $tile): void
	{
		$this->write($this->getColorSymbol($tile->getColor()));
	}

	private function drawPlayers(): void
	{
		# board
		foreach (Board::getRowNumbers() as $rowNumber) {
			foreach ($this->players as $player) {
				$row = $player->getBoard()->getRow($rowNumber);
				foreach ($row->getTiles() as $tile) {
					$this->drawTile($tile);
				}
				for ($j = 0; $j < $row->getEmptySlotsCount(); $j++) {
					$this->write(self::EMPTY_SLOT_SIGN);
				}
				$this->write(str_repeat(self::EMPTY_SLOT_SIGN, 5 - $rowNumber));
				$this->write(' | ');
				# wall
				foreach ($player->getBoard()->getPattern($row) as $tile) {
					if ($tile) {
						$this->drawTile($tile);
					} else {
						$this->write(self::EMPTY_SLOT_SIGN);
					}
				}

				$this->write("\t\t\t\t");
			}
			$this->writeln('');
		}
		$this->writeln('');

		# floor
		foreach ($this->players as $player) {
			foreach ($player->getBoard()->getFloorTiles() as $tile) {
				$this->drawTile($tile);
			}
			$this->write("\t\t\t");
		}
		$this->writeln('');
	}

	private function wait(): void
	{
		usleep(1000000);
	}
}