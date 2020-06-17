<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Exceptions;

use InvalidArgumentException;

final class DuplicatedValueException extends InvalidArgumentException
{
    /**
     * @param string[] $values
     * @param string $class
     */
    public function __construct(array $values, string $class)
    {
        parent::__construct('The values ["'.implode('", "', $values).'"] are duplicated in enum '.$class);
    }
}
