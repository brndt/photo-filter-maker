<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\Event;

use LaSalle\Performance\Shared\Domain\Event\DomainEvent;
use phpDocumentor\Reflection\Types\Iterable_;

final class PhotoCreatedDomainEvent extends DomainEvent
{
    private string $nameURL;
    private ?array $tags;
    private ?string $description;
    private string $filter;
    private ?Iterable $filtersToApply;

    public function __construct(
        string $aggregateId,
        string $nameURL,
        ?array $tags,
        string $filter,
        ?string $description,
        ?array $filtersToApply
    ) {
        parent::__construct($aggregateId);
        $this->nameURL = $nameURL;
        $this->tags = $tags;
        $this->description = $description;
        $this->filter = $filter;
        $this->filtersToApply = $filtersToApply;
    }

    public function getFiltersToApply(): array
    {
        return $this->filtersToApply;
    }

    public static function eventName(): string
    {
        return 'photo.created';
    }

    public function getNameURL(): string
    {
        return $this->nameURL;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getFilter(): string
    {
        return $this->filter;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
