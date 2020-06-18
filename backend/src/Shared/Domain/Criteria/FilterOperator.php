<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Criteria;

use LaSalle\Performance\Shared\Domain\ValueObject\Enum;
use InvalidArgumentException;

/**
 * @method static self equal()
 * @method static self not_equal()
 * @method static self gt()
 * @method static self lt()
 * @method static self contains()
 * @method static self not_contains()
 */
final class FilterOperator extends Enum
{
    public function isContaining(): bool
    {
        return in_array($this->getValue(), [self::contains(), self::not_contains()], true);
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException(sprintf('The filter <%s> is invalid', $value));
    }
}
