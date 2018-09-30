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

use League\Tactician\Handler\CommandHandlerMiddleware as TacticianHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;

final class QueryHandlerMiddleware extends TacticianHandlerMiddleware
{
    /**
     * QueryHandlerMiddleware constructor.
     *
     * @param HandlerLocator $handlerLocator
     */
    public function __construct(HandlerLocator $handlerLocator)
    {
        parent::__construct(
            new ClassNameExtractor(),
            $handlerLocator,
            new QueryInflector()
        );
    }
}
