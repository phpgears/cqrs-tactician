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

use Gears\CQRS\Async\QueuedCommand;
use League\Tactician\Handler\CommandHandlerMiddleware as TacticianHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

final class CommandHandlerMiddleware extends TacticianHandlerMiddleware
{
    /**
     * CommandHandlerMiddleware constructor.
     *
     * @param HandlerLocator            $handlerLocator
     * @param CommandNameExtractor|null $commandNameExtractor
     * @param MethodNameInflector|null  $methodNameInflector
     */
    public function __construct(
        HandlerLocator $handlerLocator,
        ?CommandNameExtractor $commandNameExtractor = null,
        ?MethodNameInflector $methodNameInflector = null
    ) {
        parent::__construct(
            $commandNameExtractor ?? new CommandExtractor(),
            $handlerLocator,
            $methodNameInflector ?? new CommandInflector()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof QueuedCommand) {
            $command = $command->getWrappedCommand();
        }

        return parent::execute($command, $next);
    }
}
