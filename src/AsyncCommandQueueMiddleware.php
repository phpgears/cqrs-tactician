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

use Gears\CQRS\Async\CommandQueue;
use Gears\CQRS\Async\Discriminator\CommandDiscriminator;
use Gears\CQRS\Async\QueuedCommand;
use Gears\CQRS\Command;
use Gears\CQRS\Exception\InvalidCommandException;
use League\Tactician\Middleware;

final class AsyncCommandQueueMiddleware implements Middleware
{
    /**
     * Command queue.
     *
     * @var CommandQueue
     */
    private $commandQueue;

    /**
     * Command discriminator.
     *
     * @var CommandDiscriminator
     */
    private $discriminator;

    /**
     * AsyncCommandQueueMiddleware constructor.
     *
     * @param CommandQueue         $commandQueue
     * @param CommandDiscriminator $discriminator
     */
    public function __construct(CommandQueue $commandQueue, CommandDiscriminator $discriminator)
    {
        $this->commandQueue = $commandQueue;
        $this->discriminator = $discriminator;
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed    $command
     * @param callable $next
     */
    public function execute($command, callable $next)
    {
        if (!$command instanceof Command) {
            throw new InvalidCommandException(\sprintf(
                'Command must implement "%s" interface, "%s" given',
                Command::class,
                \is_object($command) ? \get_class($command) : \gettype($command)
            ));
        }

        if (!$command instanceof QueuedCommand && $this->discriminator->shouldEnqueue($command)) {
            $this->commandQueue->send(new QueuedCommand($command));

            return;
        }

        return $next($command);
    }
}
