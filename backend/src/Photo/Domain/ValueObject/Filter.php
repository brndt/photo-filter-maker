<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\ValueObject;

use LaSalle\Performance\Shared\Domain\ValueObject\Enum;

class Filter extends Enum
{
    public static function original(): Filter
    {
        return new class() extends Filter {
            public function getValue(): string
            {
                return 'original';
            }
            public function getIndex(): int
            {
                return 1;
            }
        };
    }

    public static function sepia(): Filter
    {
        return new class() extends Filter {
            public function getValue(): string
            {
                return 'sepia';
            }
            public function getIndex(): int
            {
                return 2;
            }
        };
    }

    public static function desaturate(): Filter
    {
        return new class() extends Filter {
            public function getValue(): string
            {
                return 'desaturate';
            }
            public function getIndex(): int
            {
                return 3;
            }
        };
    }
}
