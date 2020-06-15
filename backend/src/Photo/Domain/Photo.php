<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain;

final class Photo
{
    private string $id;
    private string $url;
    private string $tags;
    private string $description;

    public function __construct(string $id, string $url, string $tags, string $description)
    {
        $this->id = $id;
        $this->url = $url;
        $this->tags = $tags;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
