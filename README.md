saxulum-console
===============

**works with plain silex-php**

[![Build Status](https://api.travis-ci.org/saxulum/saxulum-console.png?branch=master)](https://travis-ci.org/saxulum/saxulum-console)
[![Total Downloads](https://poser.pugx.org/saxulum/saxulum-console/downloads.png)](https://packagist.org/packages/saxulum/saxulum-console)
[![Latest Stable Version](https://poser.pugx.org/saxulum/saxulum-console/v/stable.png)](https://packagist.org/packages/saxulum/saxulum-console)

Features
--------

* Add symfony console

Requirements
------------

 * PHP 5.3+
 * Symfony Console 2.3+

Installation
------------

Through [Composer](http://getcomposer.org) as [saxulum/saxulum/saxulum-console][1].

``` {.php}
$app->register(new ConsoleProvider());
```

Usage
-----

Register a Command

``` {.php}
$app['console.commands'] = $app->share(
    $app->extend('console.commands', function (array $commands) use ($container) {
        $commands[] = new SampleCommand();

        return $commands;
    })
);
```

Copyright
---------
* Dominik Zogg <dominik.zogg@gmail.com>

[1]: https://packagist.org/packages/saxulum/saxulum-console