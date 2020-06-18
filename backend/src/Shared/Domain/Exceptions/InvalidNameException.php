<?php

declare(strict_types=1);

namespace LaSalle\Performance\Shared\Domain\Exceptions;

use InvalidArgumentException;

final class InvalidNameException extends InvalidArgumentException
{
    public function __construct($name, string $class)
    {
        $message = 'The name for an enum must be a string but '.gettype($name).' given';

        if (is_string($name)) {
            $message = 'The given name ['.$name.'] is not available in this enum '.$class;
        }

        parent::__construct($message);
    }
}
