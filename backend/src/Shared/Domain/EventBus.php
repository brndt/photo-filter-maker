<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain;

interface EventBus
{
    public function dispatch(DomainEvent $event);
}
