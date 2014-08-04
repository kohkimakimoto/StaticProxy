# StaticProxy

StaticProxy provides static interface to an instance method.
It's heavily inspired by the [Facades](http://laravel.com/docs/facades) of [Laravel](http://laravel.com/).

## Requirement

PHP5.3 or later.

## Installation

You can use composer installation.
Make `composer.json` file like the following.

```json
{
      "require": {
          "kohkimakimoto/static-proxy": "0.*"
      }
}
```

And run composer install command.

```
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar install
```

## Usage

```php
<?php
use Kohkimakimoto\StaticProxy\StaticProxy;
use Kohkimakimoto\StaticProxy\StaticProxyContainer;

$container = new StaticProxyContainer();
$container->bind("hello", new HelloworldFunctions());

StaticProxy::setContainer($container);
StaticProxy::addAlias("Hw", "Test\Kohkimakimoto\StaticProxy\Helloworld");

Hw::helloWorld();
```

## Author

Kohki Makimoto <kohki.makimoto@gmail.com>

## License

MIT
