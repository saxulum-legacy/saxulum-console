<?php

namespace Saxulum\Tests\Console\Silex\Provider;

use Pimple\Container;
use Saxulum\Console\Provider\ConsoleProvider;
use Saxulum\Tests\Console\Command\SampleCommand;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ConsoleProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testConsole()
    {
        $container = new Container();
        $container['debug'] = true;

        $container->register(new ConsoleProvider());

        $container['console.commands'] = $container->extend('console.commands', function ($commands) use ($container) {
            $command = new SampleCommand;
            $command->setContainer($container);
            $commands[] = $command;

            return $commands;
        });

        $input = new ArrayInput(array(
            'command' => 'sample:command',
            'value' => 'value'
        ));

        $output = new BufferedOutput();

        /** @var ConsoleApplication $console */
        $console = $container['console'];

        $console->setAutoExit(false);
        $console->run($input, $output);

        $this->assertEquals('this is a sample command with value: value', $output->fetch());
    }

    public function testWithCache()
    {
        $container = new Container();
        $container['debug'] = true;

        $container->register(new ConsoleProvider(), array(
            'console.cache' => __DIR__ . '/../../../../cache'
        ));

        $container['console.command.paths'] = $container->extend('console.command.paths', function ($paths) {
            $paths[] = __DIR__ . '/../Command';

            return $paths;
        });

        $input = new ArrayInput(array(
            'command' => 'sample:command',
            'value' => 'value'
        ));

        $output = new BufferedOutput();

        /** @var ConsoleApplication $console */
        $console = $container['console'];

        $console->setAutoExit(false);
        $console->run($input, $output);

        $this->assertEquals('this is a sample command with value: value', $output->fetch());
    }

    public function testWithoutCache()
    {
        $container = new Container();
        $container['debug'] = true;

        $container->register(new ConsoleProvider());

        $container['console.command.paths'] = $container->extend('console.command.paths', function ($paths) {
            $paths[] = __DIR__ . '/../Command';

            return $paths;
        });

        $input = new ArrayInput(array(
            'command' => 'sample:command',
            'value' => 'value'
        ));

        $output = new BufferedOutput();

        /** @var ConsoleApplication $console */
        $console = $container['console'];

        $console->setAutoExit(false);
        $console->run($input, $output);

        $this->assertEquals('this is a sample command with value: value', $output->fetch());
    }
}
