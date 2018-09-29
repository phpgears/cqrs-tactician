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
use Gears\CQRS\CommandBus as CommandBusInterface;
use League\Tactician\CommandBus as TacticianCommandBus;

final class CommandBus implements CommandBusInterface
{
    /**
     * Wrapped command bus.
     *
     * @var TacticianCommandBus
     */
    private $wrappedCommandBus;

    /**
     * CommandBus constructor.
     *
     * @param TacticianCommandBus $wrappedCommandBus
     */
    public function __construct(TacticianCommandBus $wrappedCommandBus)
    {
        $this->wrappedCommandBus = $wrappedCommandBus;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command): void
    {
        $this->wrappedCommandBus->handle($command);
    }
}
