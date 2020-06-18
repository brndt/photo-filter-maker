<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Criteria;

use InvalidArgumentException;
use LaSalle\Performance\Shared\Domain\ValueObject\Enum;

class OrderType extends Enum
{
    public const ASC = 'asc';
    public const DESC = 'desc';
    public const NONE = 'none';

    public function isNone(): bool
    {
        return $this->isEqual(self::none());
    }

    public static function asc(): OrderType
    {
        return new class() extends OrderType {
            public function getValue(): string
            {
                return 'asc';
            }
        };
    }

    public static function desc(): OrderType
    {
        return new class() extends OrderType {
            public function getValue(): string
            {
                return 'desc';
            }
        };
    }

    public static function none(): OrderType
    {
        return new class() extends OrderType {
            public function getValue(): string
            {
                return 'none';
            }
        };
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException($value);
    }
}
