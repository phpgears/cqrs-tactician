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
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;

final class QueryExtractor implements CommandNameExtractor
{
    /**
     * Extract the name from a query.
     *
     * @param mixed $query
     *
     * @throws InvalidQueryException
     *
     * @return string
     */
    public function extract($query)
    {
        if (!$query instanceof Query) {
            throw new InvalidQueryException(\sprintf(
                'Query must implement "%s" interface, "%s" given.',
                Query::class,
                \is_object($query) ? \get_class($query) : \gettype($query)
            ));
        }

        return $query->getQueryType();
    }
}
