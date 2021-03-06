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
            ->will(static::returnValue(new CommandHandlerStub()));
        /* @var HandlerLocator $locatorMock */

        (new CommandHandlerMiddleware($locatorMock))->execute(CommandStub::instance(), 'strlen');
    }
}
