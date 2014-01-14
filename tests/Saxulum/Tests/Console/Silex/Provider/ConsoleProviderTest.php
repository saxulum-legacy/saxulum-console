<?php

namespace Saxulum\Tests\Console\Silex\Provider;

use Saxulum\Console\Silex\Provider\ConsoleProvider;
use Saxulum\Tests\Console\Command\SampleCommand;
use Silex\Application;
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
                $commands[] = new SampleCommand(null, $app);

                return $commands;
            })
        );

        $app->boot();

        $input = new ArrayInput(array(
            'command' => 'sample:command',
            'value' => 'value'
        ));

        $output = new BufferedOutput();

        $app['console']->setAutoExit(false);
        $app['console']->run($input, $output);

        $this->assertEquals('this is a sample command with value: value', $output->fetch());
    }
}
