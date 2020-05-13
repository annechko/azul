<?php
declare(strict_types=1);
namespace Azul\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PlayGameCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'play';

    protected function configure()
    {
        $this
            ->setDescription('Starts a new game.')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Whoa!');

        return 0;
    }
}
