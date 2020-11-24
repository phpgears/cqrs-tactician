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

namespace Gears\CQRS\Tactician\Tests;

use Gears\CQRS\Exception\InvalidQueryException;
use Gears\CQRS\Exception\InvalidQueryHandlerException;
use Gears\CQRS\Tactician\QueryInflector;
use Gears\CQRS\Tactician\Tests\Stub\QueryHandlerStub;
use Gears\CQRS\Tactician\Tests\Stub\QueryStub;
use PHPUnit\Framework\TestCase;

/**
 * Query inflector test.
 */
class QueryInflectorTest extends TestCase
{
    public function testInvalidCommand(): void
    {
        $this->expectException(InvalidQueryException::class);
        $this->expectExceptionMessage('Query must implement "Gears\CQRS\Query" interface, "string" given.');

        (new QueryInflector())->inflect('', '');
    }

    public function testInvalidCommandHandler(): void
    {
        $this->expectException(InvalidQueryHandlerException::class);
        $this->expectExceptionMessage(
            'Query handler must implement "Gears\CQRS\QueryHandler" interface, "string" given.'
        );

        (new QueryInflector())->inflect(QueryStub::instance(), '');
    }

    public function testInflect(): void
    {
        $inflected = (new QueryInflector())
            ->inflect(QueryStub::instance(), new QueryHandlerStub());

        static::assertSame('handle', $inflected);
    }
}
