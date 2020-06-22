<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain\ValueObject;

use LaSalle\Performance\Shared\Domain\ValueObject\Enum;

/**
 * @method static self original()
 * @method static self sepia()
 * @method static self desaturate()
 * @method static self sketch()
 * @method static self blur()
 * @method static self sharpen()
 */
final class Filter extends Enum
{
}
