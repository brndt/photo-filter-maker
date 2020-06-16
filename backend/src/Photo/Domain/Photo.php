<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain;

use LaSalle\Performance\Photo\Domain\Event\PhotoCreatedDomainEvent;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;
use LaSalle\Performance\Shared\Domain\DomainEvent;

final class Photo
{
    private Uuid $id;
    private string $url;
    private array $tags;
    private string $description;
    private array $eventStream;

    public function __construct(Uuid $id, string $url, array $tags, string $description)
    {
        $this->id = $id;
        $this->url = $url;
        $this->tags = $tags;
        $this->description = $description;
    }

    public static function create(Uuid $id, string $url, array $tags, string $description) {
        $instance = new static(
            $id,
            $url,
            $tags,
            $description,
        );

        $instance->recordThat(
            new PhotoCreatedDomainEvent(
                $instance->getId()->toString(),
                $instance->getUrl(),
                $instance->getTags(),
                $instance->getDescription(),
            )
        );

        return $instance;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function pullDomainEvents(): array
    {
        $events = $this->eventStream ?: [];
        $this->eventStream = [];

        return $events;
    }

    private function recordThat(DomainEvent $event): void
    {
        $this->eventStream[] = $event;
    }
}
