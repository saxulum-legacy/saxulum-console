<?php

namespace Saxulum\Console\Command;

use Pimple\Container;
use Symfony\Component\Console\Command\Command;

abstract class AbstractPimpleCommand extends Command
{
    /**
     * @var Container
     */
    protected $container;

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
