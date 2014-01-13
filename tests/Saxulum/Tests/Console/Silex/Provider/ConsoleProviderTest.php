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

        $app['console'] = $app->share(
            $app->extend('console', function (ConsoleApplication $console) use ($app) {
                $console->add(new SampleCommand(null, $app));

                return $console;
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
