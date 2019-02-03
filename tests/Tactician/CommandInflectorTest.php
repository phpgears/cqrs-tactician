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

use Gears\CQRS\Tactician\CommandInflector;
use Gears\CQRS\Tactician\Tests\Stub\CommandHandlerStub;
use Gears\CQRS\Tactician\Tests\Stub\CommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Command inflector test.
 */
class CommandInflectorTest extends TestCase
{
    /**
     * @expectedException \Gears\CQRS\Exception\InvalidCommandException
     * @expectedExceptionMessage Command must implement Gears\CQRS\Command interface, string given
     */
    public function testInvalidCommand(): void
    {
        (new CommandInflector())->inflect('', '');
    }

    /**
     * @expectedException \Gears\CQRS\Exception\InvalidCommandHandlerException
     * @expectedExceptionMessage Command handler must implement Gears\CQRS\CommandHandler interface, string given
     */
    public function testInvalidCommandHandler(): void
    {
        (new CommandInflector())->inflect(CommandStub::instance(), '');
    }

    public function testInflect(): void
    {
        $inflected = (new CommandInflector())
            ->inflect(CommandStub::instance(), new CommandHandlerStub());

        $this->assertSame('handle', $inflected);
    }
}
