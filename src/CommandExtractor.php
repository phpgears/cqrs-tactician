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
use Gears\CQRS\Exception\InvalidCommandException;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;

final class CommandExtractor implements CommandNameExtractor
{
    /**
     * Extract the name from a command.
     *
     * @param mixed $command
     *
     * @throws InvalidCommandException
     *
     * @return string
     */
    public function extract($command)
    {
        if (!$command instanceof Command) {
            throw new InvalidCommandException(\sprintf(
                'Command must implement "%s" interface, "%s" given.',
                Command::class,
                \is_object($command) ? \get_class($command) : \gettype($command)
            ));
        }

        return $command->getCommandType();
    }
}
