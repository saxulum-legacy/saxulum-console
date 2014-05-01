<?php

namespace Saxulum\Tests\Console\Silex\Provider;

use Saxulum\Console\Silex\Provider\ConsoleProvider;
use Saxulum\Tests\Console\Command\SampleCommand;
use Silex\Application;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ConsoleProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testConsole()
    {
        $app = new Application();

        $app->register(new ConsoleProvider());

        $app['console.commands'] = $app->share(
            $app->extend('console.commands', function ($commands) use ($app) {
                $command = new SampleCommand;
                $command->setContainer($app);
                $commands[] = $command;

                return $commands;
            })
        );

        $app->boot();

        $input = new ArrayInput(array(
            'command' => 'sample:command',
            'value' => 'value'
        ));

        $output = new BufferedOutput();

        /** @var ConsoleApplication $console */
        $console = $app['console'];

        $console->setAutoExit(false);
        $console->run($input, $output);

        $this->assertEquals('this is a sample command with value: value', $output->fetch());
    }

    public function testWithCache()
    {
        $app = new Application();
        $app['debug'] = true;

        $app->register(new ConsoleProvider(), array(
            'console.cache' => __DIR__ . '/../../../../../../cache'
        ));

        $app['console.command.paths'] = $app->share($app->extend('console.command.paths', function ($paths) {
            $paths[] = __DIR__ . '/../../Command';

            return $paths;
        }));

        $app->boot();

        $input = new ArrayInput(array(
            'command' => 'sample:command',
            'value' => 'value'
        ));

        $output = new BufferedOutput();

        /** @var ConsoleApplication $console */
        $console = $app['console'];

        $console->setAutoExit(false);
        $console->run($input, $output);

        $this->assertEquals('this is a sample command with value: value', $output->fetch());
    }

    public function testWithoutCache()
    {
        $app = new Application();
        $app['debug'] = true;

        $app->register(new ConsoleProvider());

        $app['console.command.paths'] = $app->share($app->extend('console.command.paths', function ($paths) {
            $paths[] = __DIR__ . '/../../Command';

            return $paths;
        }));

        $app->boot();

        $input = new ArrayInput(array(
            'command' => 'sample:command',
            'value' => 'value'
        ));

        $output = new BufferedOutput();

        /** @var ConsoleApplication $console */
        $console = $app['console'];

        $console->setAutoExit(false);
        $console->run($input, $output);

        $this->assertEquals('this is a sample command with value: value', $output->fetch());
    }
}
