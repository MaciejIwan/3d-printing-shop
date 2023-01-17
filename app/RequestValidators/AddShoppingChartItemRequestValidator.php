<?php

declare(strict_types=1);

namespace App\RequestValidators;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use Valitron\Validator;

class AddShoppingChartItemRequestValidator implements RequestValidatorInterface
{

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', 'product');
        $v->rule('integer', 'product');
        $v->rule('required', 'quantity');
        $v->rule('integer', 'quantity');
//        $v->rules([
//            'required' => ['quantity', 'product'],
//            'int' => ['quantity', 'product'],
//        ]);

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }
        return $data;
    }
}
