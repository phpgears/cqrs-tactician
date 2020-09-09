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

use Gears\CQRS\Tactician\QueryBus;
use Gears\CQRS\Tactician\Tests\Stub\QueryStub;
use League\Tactician\CommandBus as TacticianBus;
use PHPUnit\Framework\TestCase;

/**
 * Tactician query bus test.
 */
class QueryBusTest extends TestCase
{
    public function testHandling(): void
    {
        $tacticianMock = $this->getMockBuilder(TacticianBus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tacticianMock->expects(static::once())
            ->method('handle')
            ->willReturn('return');
        /* @var TacticianBus $tacticianMock */

        static::assertSame('return', (new QueryBus($tacticianMock))->handle(QueryStub::instance()));
    }
}
