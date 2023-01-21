<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use App\Repository\UserRepository;
use Valitron\Validator;

class RegisterUserRequestValidator implements RequestValidatorInterface
{
    private static int $MIN_PASSWORD_LENGTH = 6;
    private static int $MAX_PASSWORD_LENGTH = 32;

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['name', 'email', 'password', 'confirmPassword']);
        $v->rule('email', 'email')->message(\App\Exceptions\ValidationException::$EMAIL_NOT_CORRECT)->label('Email');;
        $v->rule('equals', 'confirmPassword', 'password')
            ->message(ValidationException::$PASSWORDS_NOT_MATCH)
            ->label('ConfirmPassword');
        $v->rule('lengthBetween', ['password', 'confirmPassword'], static::$MIN_PASSWORD_LENGTH, static::$MAX_PASSWORD_LENGTH)
            ->message(ValidationException::$PASSWORD_LENGTH)
            ->label('Password');
        $v->rule(
            fn($field, $value, $params, $fields) => !$this->userRepository->isEmailTaken($value),
            'email'
        )->message(ValidationException::$EMAIL_TAKEN);

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
