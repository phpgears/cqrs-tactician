[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7.1-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/phpgears/cqrs-tactician.svg?style=flat-square)](https://packagist.org/packages/phpgears/cqrs-tactician)
[![License](https://img.shields.io/github/license/phpgears/cqrs-tactician.svg?style=flat-square)](https://github.com/phpgears/cqrs-tactician/blob/master/LICENSE)

[![Build Status](https://img.shields.io/travis/phpgears/cqrs-tactician.svg?style=flat-square)](https://travis-ci.org/phpgears/cqrs-tactician)
[![Style Check](https://styleci.io/repos/150868308/shield)](https://styleci.io/repos/150868308)
[![Code Quality](https://img.shields.io/scrutinizer/g/phpgears/cqrs-tactician.svg?style=flat-square)](https://scrutinizer-ci.com/g/phpgears/cqrs-tactician)
[![Code Coverage](https://img.shields.io/coveralls/phpgears/cqrs-tactician.svg?style=flat-square)](https://coveralls.io/github/phpgears/cqrs-tactician)

[![Total Downloads](https://img.shields.io/packagist/dt/phpgears/cqrs-tactician.svg?style=flat-square)](https://packagist.org/packages/phpgears/cqrs-tactician/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/phpgears/cqrs-tactician.svg?style=flat-square)](https://packagist.org/packages/phpgears/cqrs-tactician/stats)

# CQRS with Tactician

CQRS implementation with League Tactician

## Installation

### Composer

```
composer require phpgears/cqrs-tactician
```

## Usage

Require composer autoload file

```php
require './vendor/autoload.php';
```

### Commands Bus

```php
use Gears\CQRS\Tactician\CommandBus;
use Gears\CQRS\Tactician\CommandInflector;
use League\Tactician\CommandBus as TacticianBus;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Plugins\LockingMiddleware;

$commandToHandlerMap = [];
        
$tacticianBus = new TacticianBus([
    new LockingMiddleware(),
    new TacticianHandlerMiddleware(
        new ClassNameExtractor(),
        new InMemoryLocator($commandToHandlerMap),
        new CommandInflector()
    ),
]);

$commandBus = new CommandBus($tacticianBus);

/** @var \Gears\CQRS\Command $command */
$commandBus->handle($command);
```

### Query Bus

```php
use Gears\CQRS\Tactician\QueryBus;
use Gears\CQRS\Tactician\QueryInflector;
use League\Tactician\CommandBus as TacticianBus;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Plugins\LockingMiddleware;

$queryToHandlerMap = [];
        
$tacticianBus = new TacticianBus([
    new LockingMiddleware(),
    new TacticianHandlerMiddleware(
        new ClassNameExtractor(),
        new InMemoryLocator($queryToHandlerMap),
        new QueryInflector()
    ),
]);

$queryBus = new QueryBus($tacticianBus);

/** @var \Gears\CQRS\Query $query */
$result = $queryBus->handle($query);
```

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/cqrs-tactician/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/cqrs-tactician/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/cqrs-tactician/blob/master/LICENSE) included with the source code for a copy of the license terms.
