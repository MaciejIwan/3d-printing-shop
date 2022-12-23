<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionsMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if(session_status() === PHP_SESSION_ACTIVE){
            throw new \RuntimeException("Session has already started!");
        }

        if(headers_sent($filename, $line)){
            throw new \RuntimeException("Headers already sent");
        }
        session_start();

        $response = $handler->handle($request);

        session_write_close();

        return $response;
    }
}