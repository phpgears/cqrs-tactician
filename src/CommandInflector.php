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

namespace Gears\CQRS\Tactician;

use Gears\CQRS\Command;
use Gears\CQRS\CommandHandler;
use Gears\CQRS\Exception\InvalidCommandException;
use Gears\CQRS\Exception\InvalidCommandHandlerException;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

final class CommandInflector implements MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param mixed $command
     * @param mixed $handler
     *
     * @throws InvalidCommandException
     * @throws InvalidCommandHandlerException
     */
    public function inflect($command, $handler): string
    {
        if (!$command instanceof Command) {
            throw new InvalidCommandException(\sprintf(
                'Command must implement %s interface, %s given',
                Command::class,
                \is_object($command) ? \get_class($command) : \gettype($command)
            ));
        }

        if (!$handler instanceof CommandHandler) {
            throw new InvalidCommandHandlerException(\sprintf(
                'Command handler must implement %s interface, %s given',
                CommandHandler::class,
                \is_object($handler) ? \get_class($handler) : \gettype($handler)
            ));
        }

        return 'handle';
    }
}
