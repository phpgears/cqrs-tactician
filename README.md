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

As simple as adding CommandHandlerMiddleware to a Tactician's middleware list

```php
use Gears\CQRS\Tactician\CommandBus;
use Gears\CQRS\Tactician\CommandHandlerMiddleware;
use League\Tactician\CommandBus as TacticianCommandBus;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Plugins\LockingMiddleware;

$commandToHandlerMap = [];
        
$tacticianCommandBus = new TacticianCommandBus([
    new LockingMiddleware(),
    new CommandHandlerMiddleware(new InMemoryLocator($commandToHandlerMap)),
]);

$commandBus = new CommandBus($tacticianCommandBus);

/** @var \Gears\CQRS\Command $command */
$commandBus->handle($command);
```

#### Asynchronicity

To allow commands to be handled asynchronously you should include AsyncCommandQueueMiddleware before CommandHandlerMiddleware

AsyncCommandQueueMiddleware requires an implementation of `Gears\CQRS\Async\CommandQueue` which will be responsible for command queueing and an instance of `Gears\CQRS\Async\Discriminator\CommandDiscriminator` used to discriminate which commands should be queued

```php
use Gears\CQRS\Async\Discriminator\ParameterCommandDiscriminator;
use Gears\CQRS\Async\Serializer\NativePhpCommandSerializer;
use Gears\CQRS\Tactician\CommandBus;
use Gears\CQRS\Tactician\AsyncCommandQueueMiddleware;
use Gears\CQRS\Tactician\CommandHandlerMiddleware;
use League\Tactician\CommandBus as TacticianCommandBus;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Plugins\LockingMiddleware;

/* @var \Gears\CQRS\CommandBus $commandBus */

/* @var \Gears\CQRS\Async\CommandQueue $commandQueue */
$commandQueue = new CommandQueueImplementation(new NativePhpCommandSerializer());

$commandToHandlerMap = [];

$tacticianCommandBus = new TacticianCommandBus([
    new LockingMiddleware(),
    new AsyncCommandQueueMiddleware($commandQueue, new ParameterCommandDiscriminator('async')),
    new CommandHandlerMiddleware(new InMemoryLocator($commandToHandlerMap)),
]);

$commandBus = new CommandBus($tacticianCommandBus);

/** @var \Gears\CQRS\Command $command */
$commandBus->handle($command);
```

If you'd like to send different commands to different message queues you can just add more instances of AsyncCommandQueueMiddleware

To know more about how to create and configure a CommandQueue head to [phpgears/cqrs-async](https://github.com/phpgears/cqrs-async)

##### Dequeueing

This part is highly dependent on your message queue, though command serializers can be used to deserialize queue messages

This is just an example of the process

```php
use Gears\CQRS\Async\ReceivedCommand;
use Gears\CQRS\Async\Serializer\NativePhpCommandSerializer;
use Gears\CQRS\Tactician\CommandBus;
use Gears\CQRS\Tactician\CommandHandlerMiddleware;
use League\Tactician\CommandBus as TacticianCommandBus;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Plugins\LockingMiddleware;

$commandToHandlerMap = [];

$tacticianCommandBus = new TacticianCommandBus([
    new LockingMiddleware(),
    // AsyncCommandQueueMiddleware could be added
    new CommandHandlerMiddleware(new InMemoryLocator($commandToHandlerMap)),
]);

$commandBus = new CommandBus($tacticianCommandBus);

$serializer = new NativePhpCommandSerializer();

while (true) {
    /* @var your_message_queue_manager $queue */
    $message = $queue->getMessage(); // extract messages from queue

    if ($message !== null) {
        $command = $serializer->fromSerialized($message);

        $commandBus->handle(new ReceivedCommand($command));
    }
}
```

In this example the deserialized commands are wrapped in Gears\CQRS\Async\ReceivedCommand in order to avoid infinite loops should you decide to handle the commands to **the same command bus** that queued them in the first place

If you decide to use **another bus** than the one that queued the command on the dequeue side, you don't need to do this wrapping (in the example above can be removed)

### Query Bus

```php
use Gears\CQRS\Tactician\QueryBus;
use Gears\CQRS\Tactician\QueryHandlerMiddleware;
use League\Tactician\CommandBus as TacticianQueryBus;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Plugins\LockingMiddleware;

$queryToHandlerMap = [];
        
$tacticianQueryBus = new TacticianQueryBus([
    new LockingMiddleware(),
    new QueryHandlerMiddleware(new InMemoryLocator($queryToHandlerMap)),
]);

$queryBus = new QueryBus($tacticianQueryBus);

/** @var \Gears\CQRS\Query $query */
$result = $queryBus->handle($query);
```

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/cqrs-tactician/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/cqrs-tactician/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/cqrs-tactician/blob/master/LICENSE) included with the source code for a copy of the license terms.
