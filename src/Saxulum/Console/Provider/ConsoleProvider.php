<?php

namespace Saxulum\Console\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Saxulum\ClassFinder\ClassFinder;
use Saxulum\Console\Console\ConsoleApplication;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ConsoleProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container['console.cache'] = null;

        $container['console.command.paths'] = function () {
            $paths = array();

            return $paths;
        };

        $container['console.commands'] = function () use ($container) {
            $commands = array();

            return $commands;
        };

        $container['console'] = function () use ($container) {
            $console = new ConsoleApplication($container);

            // automatically detect dispatcher (e.g. in Silex applications)
            if (isset($container['dispatcher']) && !is_null($container['dispatcher'])) {
                $console->setDispatcher($container['dispatcher']);
            }
            
            foreach ($container['console.commands'] as $command) {
                $console->add($command);
            }

            if (!is_null($container['console.cache'])) {
                if (!is_null($container['console.cache']) && !is_dir($container['console.cache'])) {
                    mkdir($container['console.cache'], 0777, true);
                }

                $cacheFile = $container['console.cache'] . '/saxulum-console.php';
                if ($container['debug'] || !file_exists($cacheFile)) {
                    file_put_contents(
                        $cacheFile,
                        '<?php return ' . var_export($container['console.command.search'](), true) . ';'
                    );
                }
                $commandsMap = require($cacheFile);
            } else {
                $commandsMap = $container['console.command.search']();
            }

            foreach ($commandsMap as $commandClass) {
                $command = new $commandClass;
                $console->add($command);
            }

            return $console;
        };

        $container['console.command.search'] = $container->protect(function () use ($container) {
            $commandsMap = array();
            foreach ($container['console.command.paths'] as $path) {
                foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
                    /** @var SplFileInfo $file */
                    $classes = ClassFinder::findClasses($file->getContents());
                    foreach ($classes as $class) {
                        $reflectionClass = new \ReflectionClass($class);
                        if($reflectionClass->isSubclassOf('Saxulum\Console\Command\AbstractPimpleCommand') &&
                            $reflectionClass->isInstantiable()) {
                            $commandsMap[] = $class;
                        }
                    }
                }
            }

            return $commandsMap;
        });
    }
}
