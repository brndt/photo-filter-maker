<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain;

use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;

final class Photo
{
    private Uuid $id;
    private string $url;
    private array $tags;
    private string $description;

    public function __construct(Uuid $id, string $url, array $tags, string $description)
    {
        $this->id = $id;
        $this->url = $url;
        $this->tags = $tags;
        $this->description = $description;
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
}
