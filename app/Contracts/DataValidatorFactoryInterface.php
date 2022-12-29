<?php

namespace App\Contracts;

interface DataValidatorFactoryInterface
{

    public function make(string $class): DataValidatorInterface;
}