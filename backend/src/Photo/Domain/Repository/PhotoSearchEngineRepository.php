<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\Repository;

use LaSalle\Performance\Shared\Domain\Criteria\Criteria;

interface PhotoSearchEngineRepository
{
    public function byCriteria(Criteria $criteria): array;
}
