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
        $container['console'] = $container->share(function () use ($container) {
            $console = new ConsoleApplication();

            return $console;
        });
    }
}
