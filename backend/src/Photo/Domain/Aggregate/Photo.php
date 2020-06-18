<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\Aggregate;

use LaSalle\Performance\Photo\Domain\Event\PhotoCreatedDomainEvent;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;
use LaSalle\Performance\Photo\Domain\ValueObject\FiltersToApply;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;
use LaSalle\Performance\Shared\Domain\Event\DomainEvent;

final class Photo
{
    private Uuid $id;
    private string $nameURL;
    private ?array $tags;
    private ?string $description;
    private Filter $filter;
    private FiltersToApply $filtersToApply;
    private array $eventStream;

    public function __construct(
        Uuid $id,
        string $nameURL,
        ?array $tags,
        Filter $filter,
        ?string $description,
        FiltersToApply $filtersToApply
    )
    {
        $this->id = $id;
        $this->nameURL = $nameURL;
        $this->tags = $tags;
        $this->description = $description;
        $this->filter = $filter;
        $this->filtersToApply = $filtersToApply;
    }

    public static function create(Uuid $id, string $url, ?array $tags, Filter $filter, ?string $description, FiltersToApply $filtersToApply) {
        $instance = new static(
            $id, $url, $tags, $filter, $description, $filtersToApply
        );

        $instance->recordThat(
            new PhotoCreatedDomainEvent(
                $instance->getId()->toString(),
                $instance->getNameURL(),
                $instance->getTags(),
                $instance->getFilter()->getValue(),
                $instance->getDescription(),
                $instance->getFiltersToApply()->toArrayOfPrimitives()
            )
        );

        return $instance;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getNameURL(): string
    {
        return $this->nameURL;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFilter(): Filter
    {
        return $this->filter;
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

    public function getFiltersToApply(): ?FiltersToApply
    {
        return $this->filtersToApply;
    }

    public function toPrimitives(): array
    {
        return [
            'id'       => $this->id->toString(),
            'nameURL'     => $this->nameURL,
            'tags' => $this->tags,
            'description' => $this->description,
            'filter' => $this->filter->getValue(),
            'filtersToApply' => $this->filtersToApply
        ];
    }
}
