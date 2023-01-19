<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use Valitron\Validator;

class UpdateChartItemRequestValidator implements RequestValidatorInterface
{
    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['quantity', 'id']);
        $v->rule('integer', ['quantity', 'id']);

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
