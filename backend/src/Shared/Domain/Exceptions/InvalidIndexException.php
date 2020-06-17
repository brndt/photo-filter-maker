<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Exceptions;

use InvalidArgumentException;

final class InvalidIndexException extends InvalidArgumentException
{
    public function __construct($index, string $class)
    {
        $message = 'The index for an enum must be an int but '.gettype($index).' given';

        if (is_int($index)) {
            $message = 'The given index ['.$index.'] is not available in this enum '.$class;
        }

        parent::__construct($message);
    }
}
