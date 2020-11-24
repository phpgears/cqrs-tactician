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

use Gears\CQRS\Exception\InvalidCommandException;
use Gears\CQRS\Tactician\CommandExtractor;
use Gears\CQRS\Tactician\Tests\Stub\CommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Command extractor test.
 */
class CommandExtractorTest extends TestCase
{
    public function testInvalidCommand(): void
    {
        $this->expectException(InvalidCommandException::class);
        $this->expectExceptionMessage('Command must implement "Gears\CQRS\Command" interface, "stdClass" given.');

        (new CommandExtractor())->extract(new \stdClass());
    }

    public function testExtract(): void
    {
        $type = (new CommandExtractor())->extract(CommandStub::instance());

        static::assertSame(CommandStub::class, $type);
    }
}
