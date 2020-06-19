<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Response;

final class PhotoResponse
{
    private string $id;
    private string $nameURL;
    private ?array $tags;
    private ?string $description;
    private string $filter;
    private array $filtersToApply;

    public function __construct(
        string $id,
        string $nameURL,
        ?array $tags,
        string $filter,
        ?string $description,
        array $filtersToApply
    )
    {
        $this->id = $id;
        $this->nameURL = $nameURL;
        $this->tags = $tags;
        $this->description = $description;
        $this->filter = $filter;
        $this->filtersToApply = $filtersToApply;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNameURL(): string
    {
        return $this->nameURL;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFilter(): string
    {
        return $this->filter;
    }

    public function getFiltersToApply(): array
    {
        return $this->filtersToApply;
    }
}
