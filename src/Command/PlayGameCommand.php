<?php

declare(strict_types=1);

namespace Azul\Command;

use Azul\Board\Board;
use Azul\Game\Bag;
use Azul\Game\Game;
use Azul\Player\Player;
use Azul\Player\PlayerCollection;
use Azul\Report\ConsoleReporter;
use Azul\Tile\TileFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PlayGameCommand extends Command
{
	protected static $defaultName = 'play';

	protected function configure()
	{
		$this
			->setDescription('Starts a new game.')
			->setHelp('This command allows you to create a user...');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('Let\'s start!');

		$players = new PlayerCollection([
			new Player(new Board(), 'Ivan', ),
			new Player(new Board(), 'Petr', ),
		]);
		$bag = new Bag((new TileFactory())->createGameTiles());

		$dispatcher = new EventDispatcher();
		$dispatcher->addSubscriber(new ConsoleReporter($players, new ConsoleOutput()));
		$game = new Game($bag, $dispatcher);

		$game->play($players);

		return 0;
	}
}
