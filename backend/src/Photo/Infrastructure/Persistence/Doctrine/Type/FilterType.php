<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;

final class FilterType extends Type
{
    const NAME = 'filter';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Filter::make($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getValue();
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
