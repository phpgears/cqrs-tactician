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

use Gears\CQRS\Exception\QueryReturnException;
use Gears\CQRS\Query;
use Gears\CQRS\QueryBus as QueryBusInterface;
use Gears\DTO\DTO;
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
     *
     * @throws QueryReturnException
     */
    public function handle(Query $query): DTO
    {
        $dto = $this->wrappedCommandBus->handle($query);

        if (!$dto instanceof DTO) {
            throw new QueryReturnException(\sprintf(
                'Query handler for "%s" should return an instance of "%s".',
                \get_class($query),
                DTO::class
            ));
        }

        return $dto;
    }
}
