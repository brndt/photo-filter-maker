<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Request;

final class SearchPhotosByCriteriaRequest
{
    private array $filters;
    private ?string $orderBy;
    private ?string $order;
    private ?int $offset;
    private ?int $limit;

    public function __construct(
        array $filters,
        ?string $orderBy,
        ?string $order,
        ?int $offset,
        ?int $limit
    ) {
        $this->filters = $filters;
        $this->orderBy = $orderBy;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
