<?php

declare(strict_types=1);

namespace App\DataValidators;

use App\Contracts\DataValidatorInterface;
use App\Exceptions\ValidationException;
use Valitron\Validator;

class CreateOrderDataValidator implements DataValidatorInterface
{
    public function validate(array $formData): array
    {
        $v = new Validator($formData);

        //todo add validation rules
        $v->rule('required', ['amount']);

        if (!$v->validate()) {
            throw new ValidationException([]);
        }

        return $formData;
    }
}