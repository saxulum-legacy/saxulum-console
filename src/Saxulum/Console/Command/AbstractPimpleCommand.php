<?php

namespace Saxulum\Console\Command;

use Symfony\Component\Console\Command\Command;

abstract class AbstractPimpleCommand extends Command
{
    /**
     * @var \Pimple
     */
    protected $container;

    public function setContainer(\Pimple $container)
    {

    }
}
