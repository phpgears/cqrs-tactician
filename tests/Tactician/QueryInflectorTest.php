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

use Gears\CQRS\Tactician\QueryInflector;
use Gears\CQRS\Tactician\Tests\Stub\QueryHandlerStub;
use Gears\CQRS\Tactician\Tests\Stub\QueryStub;
use PHPUnit\Framework\TestCase;

/**
 * Query inflector test.
 */
class QueryInflectorTest extends TestCase
{
    /**
     * @expectedException \Gears\CQRS\Exception\InvalidQueryException
     * @expectedExceptionMessage Query must implement Gears\CQRS\Query interface, string given
     */
    public function testInvalidCommand(): void
    {
        (new QueryInflector())->inflect('', '');
    }

    /**
     * @expectedException \Gears\CQRS\Exception\InvalidQueryHandlerException
     * @expectedExceptionMessage Query handler must implement Gears\CQRS\QueryHandler interface, string given
     */
    public function testInvalidCommandHandler(): void
    {
        (new QueryInflector())->inflect(QueryStub::instance(), '');
    }

    public function testInflect(): void
    {
        $inflected = (new QueryInflector())
            ->inflect(QueryStub::instance(), new QueryHandlerStub());

        $this->assertSame('handle', $inflected);
    }
}
