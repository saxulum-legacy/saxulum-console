<?php

namespace Saxulum\Console\Provider;

use Symfony\Component\Console\Application as ConsoleApplication;

class ConsoleProvider
{
    /**
     * @param \Pimple $container
     */
    public function register(\Pimple $container)
    {
        $container['console.commands'] = $container->share(function () use ($container) {
            $commands = array();

            return $commands;
        });

        $container['console'] = $container->share(function () use ($container) {
            $console = new ConsoleApplication();
            foreach ($container['console.commands'] as $command) {
                $console->add($command);
            }

            return $console;
        });
    }
}
