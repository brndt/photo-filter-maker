<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Criteria;

use InvalidArgumentException;
use LaSalle\Performance\Shared\Domain\ValueObject\Enum;

/**
 * @method static self asc()
 * @method static self desc()
 * @method static self none()
 */
class OrderType extends Enum
{
    public function isNone(): bool
    {
        return $this->isEqual(self::none());
    }
}
