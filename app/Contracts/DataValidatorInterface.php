<?php

namespace App\Contracts;

interface DataValidatorInterface
{
    public function validate(array $formData): array;
}