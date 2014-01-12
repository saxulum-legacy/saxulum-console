<?php

namespace Saxulum\Console\Command;

use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    /**
     * @var \Pimple
     */
    protected $container;

    public function __construct($name = null, \Pimple $container)
    {
        $this->container = $container;
        parent::__construct($name);
    }
}
