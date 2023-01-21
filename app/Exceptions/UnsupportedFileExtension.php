<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class UnsupportedFileExtension extends RuntimeException
{
    public static string $UNSUPPORTED_FILE_EXTENSION_MESSAGE = "We accept .stl files only";
}
