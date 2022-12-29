<?php

declare(strict_types=1);

namespace App\DataValidators;

use App\Contracts\DataValidatorFactoryInterface;
use App\Contracts\DataValidatorInterface;
use Psr\Container\ContainerInterface;

class DataValidatorFactory implements DataValidatorFactoryInterface
{

    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function make(string $class): DataValidatorInterface
    {

        $validator = $this->container->get($class);
        if ($validator instanceof DataValidatorInterface) {
            return $validator;
        }

        throw new \RuntimeException("Failed to get DataValidator" . $class . " instance");

    }
}