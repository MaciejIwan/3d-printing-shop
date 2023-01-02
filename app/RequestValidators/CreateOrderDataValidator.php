<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use Valitron\Validator;

class CreateOrderDataValidator implements RequestValidatorInterface
{
    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', 'name');

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
