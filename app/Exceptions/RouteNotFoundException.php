<?php
declare(strict_types=1);

namespace app\Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = '404 Not Found';
}