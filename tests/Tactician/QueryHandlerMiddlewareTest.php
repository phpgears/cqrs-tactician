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

use Gears\CQRS\Tactician\QueryHandlerMiddleware;
use Gears\CQRS\Tactician\Tests\Stub\QueryHandlerStub;
use Gears\CQRS\Tactician\Tests\Stub\QueryStub;
use League\Tactician\Handler\Locator\HandlerLocator;
use PHPUnit\Framework\TestCase;

class QueryHandlerMiddlewareTest extends TestCase
{
    public function testHandling(): void
    {
        $locatorMock = $this->getMockBuilder(HandlerLocator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $locatorMock->expects(static::once())
            ->method('getHandlerForCommand')
            ->willReturn(new QueryHandlerStub());
        /* @var HandlerLocator $locatorMock */

        static::assertTrue((new QueryHandlerMiddleware($locatorMock))->execute(QueryStub::instance(), 'strlen'));
    }
}
