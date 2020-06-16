<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;

final class UuidType extends Type
{
    const NAME = 'uuid';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Uuid($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
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
