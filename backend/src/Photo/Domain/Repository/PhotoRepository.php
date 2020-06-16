<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\Repository;

use LaSalle\Performance\Photo\Domain\Photo;

interface PhotoRepository
{
    public function save(Photo $photo): void;
}
