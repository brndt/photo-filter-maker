<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;
use LaSalle\Performance\Photo\Domain\ValueObject\FiltersToApply;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;

final class FiltersType extends Type
{
    const NAME = 'filtersToApply';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return FiltersToApply::fromArrayOfPrimitives(explode(",", $value));
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (false == is_string($value)) {
            return implode(",", ($value->toArrayOfPrimitives()));
        }
        return $value;
    }

    public function getName()
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'VARCHAR(255)';
    }
}
