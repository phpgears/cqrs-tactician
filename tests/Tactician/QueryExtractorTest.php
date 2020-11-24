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
use Gears\CQRS\Tactician\QueryExtractor;
use Gears\CQRS\Tactician\Tests\Stub\QueryStub;
use PHPUnit\Framework\TestCase;

/**
 * Query extractor test.
 */
class QueryExtractorTest extends TestCase
{
    public function testInvalidQuery(): void
    {
        $this->expectException(InvalidQueryException::class);
        $this->expectExceptionMessage('Query must implement "Gears\CQRS\Query" interface, "stdClass" given.');

        (new QueryExtractor())->extract(new \stdClass());
    }

    public function testExtract(): void
    {
        $type = (new QueryExtractor())->extract(QueryStub::instance());

        static::assertSame(QueryStub::class, $type);
    }
}
