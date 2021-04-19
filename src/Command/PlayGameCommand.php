<?php

declare(strict_types=1);

namespace Azul\Command;

use Azul\Board\Board;
use Azul\Game\Bag;
use Azul\Game\Game;
use Azul\Player\Player;
use Azul\Player\PlayerCollection;
use Azul\Report\ConsoleReporter;
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
		$this->setDescription('Starts a new game.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('Let\'s start!');

		$players = new PlayerCollection([
			new Player(new Board(), 'Ivan', ),
			new Player(new Board(), 'Petr', ),
		]);

		$dispatcher = new EventDispatcher();
		$dispatcher->addSubscriber(new ConsoleReporter($players, new ConsoleOutput()));
		$game = new Game(Bag::create(), $dispatcher);

		$game->play($players);

		return 0;
	}
}
