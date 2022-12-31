<?php

namespace App\Controllers;


use App\Contracts\DataValidatorFactoryInterface;
use App\DataValidators\CreateOrderDataValidator;
use App\Dto\OrderAddDto;
use App\Enums\OrderStatus;
use App\Services\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class OrderController
{

    public function __construct(
        private readonly Twig                          $twig,
        private readonly DataValidatorFactoryInterface $dataValidatorFactory,
        private readonly OrderService                  $orderService,
    )
    {
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->twig->render(
            $response,
            'orders/index.twig',
        );
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $this->dataValidatorFactory->make(CreateOrderDataValidator::class)->validate(
            $request->getParsedBody()
        );

        $this->orderService->create(
            new OrderAddDto((int)$data['amount'], OrderStatus::New)
        );

        return $response->withHeader('Location', '/orders')->withStatus(302);
    }

    public function delete(Request $request, Response $response): Response
    {
        // TODO

        return $response->withHeader('Location', '/orders')->withStatus(302);
    }


}