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

use Gears\CQRS\Exception\InvalidCommandException;
use Gears\CQRS\Exception\InvalidCommandHandlerException;
use Gears\CQRS\Tactician\CommandInflector;
use Gears\CQRS\Tactician\Tests\Stub\CommandHandlerStub;
use Gears\CQRS\Tactician\Tests\Stub\CommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Command inflector test.
 */
class CommandInflectorTest extends TestCase
{
    public function testInvalidCommand(): void
    {
        $this->expectException(InvalidCommandException::class);
        $this->expectExceptionMessage('Command must implement "Gears\CQRS\Command" interface, "string" given');

        (new CommandInflector())->inflect('', '');
    }

    public function testInvalidCommandHandler(): void
    {
        $this->expectException(InvalidCommandHandlerException::class);
        $this->expectExceptionMessage(
            'Command handler must implement "Gears\CQRS\CommandHandler" interface, "string" given'
        );

        (new CommandInflector())->inflect(CommandStub::instance(), '');
    }

    public function testInflect(): void
    {
        $inflected = (new CommandInflector())
            ->inflect(CommandStub::instance(), new CommandHandlerStub());

        static::assertSame('handle', $inflected);
    }
}
