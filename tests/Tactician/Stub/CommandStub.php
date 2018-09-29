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

use Gears\CQRS\AbstractCommand;

/**
 * Command stub class.
 */
class CommandStub extends AbstractCommand
{
    /**
     * Instantiate command.
     *
     * @return self
     */
    public static function instance(): self
    {
        return new self([]);
    }
}
