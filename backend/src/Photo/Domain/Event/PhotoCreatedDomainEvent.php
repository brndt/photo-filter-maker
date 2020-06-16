<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\Event;

use LaSalle\Performance\Shared\Domain\DomainEvent;

final class PhotoCreatedDomainEvent extends DomainEvent
{
    private string $url;
    private array $tags;
    private string $description;

    public function __construct(
        string $aggregateId,
        string $url,
        array $tags,
        string $description
    ) {
        parent::__construct($aggregateId);
        $this->url = $url;
        $this->tags = $tags;
        $this->description = $description;
    }

    public static function eventName(): string
    {
        return 'photo.created';
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
}
