<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Event;

interface EventBus
{
    public function dispatch(DomainEvent $event);
}
