<?php

declare(strict_types=1);

namespace App\DataValidators;

use App\Contracts\DataValidatorInterface;
use App\Exceptions\ValidationException;
use App\Repository\UserRepository;
use Valitron\Validator;

class UserLoginDataValidator implements DataValidatorInterface
{

    public function __construct()
    {
    }

    public function validate(array $formData): array
    {
        $v = new Validator($formData);

        $v->rule('required', ['email', 'password']);
        $v->rule('email', 'email')->message(ValidationException::$EMAIL_NOT_CORRECT)->label('Email');;

        if (!$v->validate()) {
            throw new ValidationException(['password' => ['email or password is not valid']]);
        }

        return $formData;
    }
}