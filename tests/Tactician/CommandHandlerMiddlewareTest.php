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

use Gears\CQRS\Async\ReceivedCommand;
use Gears\CQRS\Tactician\CommandHandlerMiddleware;
use Gears\CQRS\Tactician\Tests\Stub\CommandHandlerStub;
use Gears\CQRS\Tactician\Tests\Stub\CommandStub;
use League\Tactician\Handler\Locator\HandlerLocator;
use PHPUnit\Framework\TestCase;

class CommandHandlerMiddlewareTest extends TestCase
{
    public function testHandling(): void
    {
        $locatorMock = $this->getMockBuilder(HandlerLocator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $locatorMock->expects(static::once())
            ->method('getHandlerForCommand')
            ->willReturn(new CommandHandlerStub());
        /* @var HandlerLocator $locatorMock */

        static::assertNull((new CommandHandlerMiddleware($locatorMock))
            ->execute(new ReceivedCommand(CommandStub::instance()), 'strlen'));
    }
}
