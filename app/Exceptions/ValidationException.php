<?php

declare(strict_types=1);

namespace App\Exceptions;

use Laminas\Code\Exception\RuntimeException;

class ValidationException extends RuntimeException
{
    public static string $EMAIL_TAKEN = 'User with the given email address already exists';
    public static string $PASSWORDS_NOT_MATCH = 'Passwords are not the same';
    public static string $PASSWORD_LENGTH = 'Password must have 6-32 characters';
    public static string $EMAIL_NOT_CORRECT = "Given email is not valid";

    public function __construct(
        public readonly array $errors,
        string                $message = 'Validation Error(s)',
        int                   $code = 422,
        ?\Throwable           $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}