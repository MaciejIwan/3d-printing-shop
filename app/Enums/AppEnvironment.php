<?php

declare(strict_types=1);

namespace App\Enums;

enum AppEnvironment: string
{
    case Development = 'development';
    case Production = 'production';

    public static function isProduction(string $appEnvironment): bool
    {
        return self::tryFrom($appEnvironment) === self::Production;
    }

    public static function isDevelopment(string $appEnvironment): bool
    {
        return self::tryFrom($appEnvironment) === self::Development;
    }
}