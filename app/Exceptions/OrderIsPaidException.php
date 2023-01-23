<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class OrderIsPaidException extends RuntimeException
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}
