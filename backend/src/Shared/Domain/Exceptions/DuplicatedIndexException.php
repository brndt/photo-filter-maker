<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Exceptions;

use InvalidArgumentException;

final class DuplicatedIndexException extends InvalidArgumentException
{
    /**
     * @param int[] $indices
     * @param string $class
     */
    public function __construct(array $indices, string $class)
    {
        parent::__construct('The indices ['.implode(', ', $indices).'] are duplicated in enum '.$class);
    }
}
