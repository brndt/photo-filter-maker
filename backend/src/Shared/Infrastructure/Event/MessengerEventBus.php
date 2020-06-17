<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Infrastructure\Event;

use LaSalle\Performance\Shared\Domain\Event\DomainEvent;
use LaSalle\Performance\Shared\Domain\Event\EventBus;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventBus implements EventBus
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch(DomainEvent $event)
    {
        $envelope = new Envelope($event, [new AmqpStamp($event::eventName())]);
        $this->eventBus->dispatch($envelope);
    }
}
