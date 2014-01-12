<?php

namespace Saxulum\Console\Silex\Provider;

use Saxulum\Console\Provider\ConsoleProvider as BaseConsoleProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ConsoleProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $pimpleServiceProvider = new BaseConsoleProvider;
        $pimpleServiceProvider->register($app);
    }
}
