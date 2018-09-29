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

namespace Gears\CQRS\Tactician\Tests\Stub;

use Gears\CQRS\AbstractCommandHandler;
use Gears\CQRS\Command;

/**
 * Command handler stub class.
 */
class CommandHandlerStub extends AbstractCommandHandler
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedCommandType(): string
    {
        return CommandStub::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleCommand(Command $command): void
    {
    }
}
