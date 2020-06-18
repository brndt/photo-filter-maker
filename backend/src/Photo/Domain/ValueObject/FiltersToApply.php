<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\ValueObject;

use LaSalle\Performance\Shared\Domain\ValueObject\Collection;

final class FiltersToApply extends Collection
{
    protected function type(): string
    {
        return Filter::class;
    }

    public function toArrayOfPrimitives(): array
    {
        return array_map(fn(Filter $filter) => $filter->getValue(), $this->items());
    }

    public static function fromArrayOfPrimitives(array $filters): FiltersToApply
    {
        return new FiltersToApply(array_map(fn(string $filter) => Filter::make($filter), $filters));
    }
}
