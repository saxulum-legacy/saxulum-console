<?php

namespace Saxulum\Console\Console;

use Saxulum\Console\Command\AbstractPimpleCommand;
use Symfony\Component\Console\Application as BaseConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleApplication extends BaseConsoleApplication
{
    /**
     * @var \Pimple
     */
    protected $container;

    public function __construct(\Pimple $container)
    {
        parent::__construct();

        $this->container = $container;

        $this->getDefinition()->addOption(
            new InputOption(
                '--env', '-e',
                InputOption::VALUE_REQUIRED,
                'The Environment name.',
                isset($this->container['env']) ? $this->container['env'] : 'dev'
            )
        );
        $this->getDefinition()->addOption(
            new InputOption(
                '--no-debug', null,
                InputOption::VALUE_NONE,
                'Switches off debug mode.'
            )
        );
    }

    /**
     * @param  Command $command
     * @return Command
     */
    public function add(Command $command)
    {
        if ($command instanceof AbstractPimpleCommand) {
            $command->setContainer($this->container);
        }

        return parent::add($command);
    }

    public function configureIO(InputInterface $input, OutputInterface $output)
    {
        $this->container['env'] = $input->getParameterOption(array('--env', '-e'));
        $this->container['debug'] = $this->container['env'] === 'prod' || $input->hasParameterOption(array('--no-debug'));

        parent::configureIO($input, $output);
    }
}
