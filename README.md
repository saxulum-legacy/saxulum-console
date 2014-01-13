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

Register a command

``` {.php}
$app['console'] = $app->share(
    $app->extend('console', function (Application $console) use ($app) {
        $console->add(new SampleCommand(null, $app));

        return $console;
    })
);
```

Run the console

``` {.php}
$app->boot();
$app['console']->run();
```

Copyright
---------
* Dominik Zogg <dominik.zogg@gmail.com>

[1]: https://packagist.org/packages/saxulum/saxulum-console