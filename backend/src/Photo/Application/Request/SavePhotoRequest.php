<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Request;

final class SavePhotoRequest
{
    private string $nameURL;
    private array $tags;
    private string $description;
    private array $filters;

    public function __construct(string $nameURL, array $tags, string $description, array $filters)
    {
        $this->nameURL = $nameURL;
        $this->tags = $tags;
        $this->description = $description;
        $this->filters = $filters;
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

    public function getFilters(): array
    {
        return $this->filters;
    }
}
