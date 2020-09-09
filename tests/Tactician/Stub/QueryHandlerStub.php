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

use Gears\CQRS\AbstractQueryHandler;

/**
 * Query handler stub class.
 */
class QueryHandlerStub extends AbstractQueryHandler
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedQueryTypes(): array
    {
        return [QueryStub::class];
    }

    /**
     * @param QueryStub $query
     *
     * @return bool
     */
    protected function handleQueryStub(QueryStub $query): bool
    {
        return true;
    }
}
