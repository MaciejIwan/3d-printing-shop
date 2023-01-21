<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Contracts\SessionInterface;
use App\Exceptions\UnsupportedFileExtension;
use App\ResponseFormatter;
use App\Services\RequestService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UnspportedFileExtensionExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly SessionInterface         $session,
        private readonly RequestService           $requestService,
        private readonly ResponseFormatter        $responseFormatter
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (UnsupportedFileExtension $e) {
            $response = $this->responseFactory->createResponse();

            if ($this->requestService->isXhr($request)) {
                return $this->responseFormatter->asJson($response->withStatus(422), ["message" => $e::$UNSUPPORTED_FILE_EXTENSION_MESSAGE]);
            }

            $referer = $this->requestService->getReferer($request);

            return $response->withHeader('Location', $referer)->withStatus(302);
        }
    }
}
