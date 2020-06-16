<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain;

use DateTimeImmutable;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    private string $aggregateId;
    protected string $id;
    private string $occurredOn;

    public function __construct(string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->id = Uuid::generate()->toString();
        $this->occurredOn = (new DateTimeImmutable())->format('Y-m-d H:i:s');
    }

    abstract public static function eventName(): string;


    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOccurredOn(): string
    {
        return $this->occurredOn;
    }
}
