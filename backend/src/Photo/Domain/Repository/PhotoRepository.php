<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\Repository;

use LaSalle\Performance\Photo\Domain\Aggregate\Photo;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;

interface PhotoRepository
{
    public function nextIdentity(): Uuid;
    public function save(Photo $photo): void;
}
