<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Infrastructure\Bus\Command;

use Arcmedia\Shared\Domain\Bus\Command\Command;
use Arcmedia\Shared\Domain\Bus\Command\CommandBus;
use Arcmedia\Shared\Infrastructure\Bus\HandlerBuilder;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Throwable;

final class InMemorySymfonyCommandBus implements CommandBus
{
    private readonly MessageBus $bus;

    /**
     * @throws \ReflectionException
     */
    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    HandlerBuilder::fromCallables($commandHandlers),
                ),
            ),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredError($command);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious() ?? $e;
        }
    }
}