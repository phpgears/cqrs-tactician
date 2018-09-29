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

use Gears\CQRS\Exception\InvalidQueryException;
use Gears\CQRS\Query;
use Gears\CQRS\QueryHandler;
use Gears\CQRS\Tactician\Exception\InvalidQueryHandlerException;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

final class QueryInflector implements MethodNameInflector
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidQueryException
     * @throws InvalidQueryHandlerException
     */
    public function inflect($command, $handler): string
    {
        if (!$command instanceof Query) {
            throw new InvalidQueryException(\sprintf(
                'Query must implement %s interface, %s given',
                Query::class,
                \is_object($command) ? \get_class($command) : \gettype($command)
            ));
        }

        if (!$handler instanceof QueryHandler) {
            throw new InvalidQueryHandlerException(\sprintf(
                'Query handler must implement %s interface, %s given',
                QueryHandler::class,
                \is_object($handler) ? \get_class($handler) : \gettype($handler)
            ));
        }

        return 'handle';
    }
}
