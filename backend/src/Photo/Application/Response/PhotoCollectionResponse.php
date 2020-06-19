<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Response;

use LaSalle\Performance\Shared\Domain\ValueObject\Collection;

final class PhotoCollectionResponse extends Collection
{
    protected function type(): string
    {
        return PhotoResponse::class;
    }
}
