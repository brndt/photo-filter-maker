<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Infrastructure\Event;

use LaSalle\Performance\Shared\Domain\DomainEvent;
use LaSalle\Performance\Shared\Domain\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventBus implements EventBus
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch(DomainEvent $event, string $eventName = null)
    {
        $this->eventBus->dispatch($event);
    }
}
