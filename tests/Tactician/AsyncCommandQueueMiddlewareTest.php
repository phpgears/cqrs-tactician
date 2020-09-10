<?php

/*
 * cqrs-tactician (https://github.com/phpgears/cqrs-tactician).
 * CQRS implementation with League Tactician.
 *
 * @license MIT
 * @link https://github.com/phpgears/cqrs-tactician
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Gears\CQRS\Tactician\Tests;

use Gears\CQRS\Async\CommandQueue;
use Gears\CQRS\Async\Discriminator\CommandDiscriminator;
use Gears\CQRS\Async\ReceivedCommand;
use Gears\CQRS\Command;
use Gears\CQRS\Exception\InvalidCommandException;
use Gears\CQRS\Tactician\AsyncCommandQueueMiddleware;
use Gears\CQRS\Tactician\Tests\Stub\CommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Asynchronous CommandQueue middleware test.
 */
class AsyncCommandQueueMiddlewareTest extends TestCase
{
    public function testInvalidCommand(): void
    {
        $this->expectException(InvalidCommandException::class);
        $this->expectExceptionMessage('Command must implement "Gears\CQRS\Command" interface, "stdClass" given');

        $commandQueue = $this->getMockBuilder(CommandQueue::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandDiscriminator = $this->getMockBuilder(CommandDiscriminator::class)
            ->disableOriginalConstructor()
            ->getMock();

        (new AsyncCommandQueueMiddleware($commandQueue, $commandDiscriminator))->execute(new \stdClass(), 'strlen');
    }

    public function testShouldEnqueue(): void
    {
        $commandQueue = $this->getMockBuilder(CommandQueue::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandQueue->expects(static::once())
            ->method('send');
        $commandDiscriminator = $this->getMockBuilder(CommandDiscriminator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandDiscriminator->expects(static::once())
            ->method('shouldEnqueue')
            ->willReturn(true);

        (new AsyncCommandQueueMiddleware($commandQueue, $commandDiscriminator))
            ->execute(CommandStub::instance(), 'strlen');
    }

    public function testShouldNotEnqueue(): void
    {
        $commandQueue = $this->getMockBuilder(CommandQueue::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandQueue->expects(static::never())
            ->method('send');
        $commandDiscriminator = $this->getMockBuilder(CommandDiscriminator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandDiscriminator->expects(static::once())
            ->method('shouldEnqueue')
            ->willReturn(false);

        $mockCommand = CommandStub::instance();

        $callable = function (Command $command) use ($mockCommand): void {
            static::assertSame($command, $mockCommand);
        };

        (new AsyncCommandQueueMiddleware($commandQueue, $commandDiscriminator))
            ->execute($mockCommand, $callable);
    }

    public function testShouldNotEnqueueReceivedCommand(): void
    {
        $commandQueue = $this->getMockBuilder(CommandQueue::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandQueue->expects(static::never())
            ->method('send');
        $commandDiscriminator = $this->getMockBuilder(CommandDiscriminator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commandDiscriminator->expects(static::never())
            ->method('shouldEnqueue');

        $mockCommand = new ReceivedCommand(CommandStub::instance());

        $callable = function (Command $command) use ($mockCommand): void {
            static::assertSame($command, $mockCommand);
        };

        (new AsyncCommandQueueMiddleware($commandQueue, $commandDiscriminator))
            ->execute($mockCommand, $callable);
    }
}
