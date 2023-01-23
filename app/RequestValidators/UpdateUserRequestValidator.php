<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use App\Repository\UserRepository;
use Valitron\Validator;

class UpdateUserRequestValidator implements RequestValidatorInterface
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function validate(array $data, string $currentEmail = null): array
    {
        $v = new Validator($data);

        $v->rule('required', ['name', 'email', 'role']);
        $v->rule('email', 'email')->message(ValidationException::$EMAIL_NOT_CORRECT)->label('Email');

        if (!is_null($currentEmail) && $data['email'] !== $currentEmail) {
            $v->rule(
                fn($field, $value, $params, $fields) => !$this->userRepository->isEmailTaken($value),
                'email'
            )->message(ValidationException::$EMAIL_TAKEN);
        }

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
