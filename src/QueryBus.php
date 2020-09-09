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

use Gears\CQRS\Query;
use Gears\CQRS\QueryBus as QueryBusInterface;
use League\Tactician\CommandBus as TacticianCommandBus;

final class QueryBus implements QueryBusInterface
{
    /**
     * Wrapped command bus.
     *
     * @var TacticianCommandBus
     */
    private $wrappedCommandBus;

    /**
     * QueryBus constructor.
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
    public function handle(Query $query)
    {
        return $this->wrappedCommandBus->handle($query);
    }
}
