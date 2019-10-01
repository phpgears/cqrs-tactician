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

use Gears\CQRS\Tactician\CommandBus;
use Gears\CQRS\Tactician\Tests\Stub\CommandStub;
use League\Tactician\CommandBus as TacticianBus;
use PHPUnit\Framework\TestCase;

/**
 * Tactician command bus test.
 */
class CommandBusTest extends TestCase
{
    public function testHandling(): void
    {
        $tacticianMock = $this->getMockBuilder(TacticianBus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tacticianMock->expects(static::once())
            ->method('handle');
        /* @var TacticianBus $tacticianMock */

        (new CommandBus($tacticianMock))->handle(CommandStub::instance());
    }
}
