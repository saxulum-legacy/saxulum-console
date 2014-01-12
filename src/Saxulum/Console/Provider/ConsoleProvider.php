<?php

namespace Saxulum\Console\Provider;

use Symfony\Component\Console\Application;

class ConsoleProvider
{
    /**
     * @param \Pimple $container
     */
    public function register(\Pimple $container)
    {
        $container['console.commands'] = array();

        $container['console'] = $container->share(function () use($container) {
            $console = new Application();
            foreach($container['console.commands'] as $command) {
                $console->add($command);
            }

            return $console;
        });
    }
}
