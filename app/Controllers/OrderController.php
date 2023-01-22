<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Dto\OrderAddDto;
use App\Dto\OrderUpdateDto;
use App\Entity\User;
use App\RequestValidators\CreateOrderDataValidator;
use App\RequestValidators\UpdateOrderRequestValidator;
use App\ResponseFormatter;
use App\Services\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class OrderController
{
    public function __construct(
        private readonly Twig                             $twig,
        private readonly RequestValidatorFactoryInterface $requestValidatorFactory,
        private readonly OrderService                     $orderService,
        private readonly ResponseFormatter                $responseFormatter
    )
    {
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->twig->render(
            $response,
            'orders/index.twig',
            [
                'orders' => $this->orderService->getAll(),
            ]
        );
    }

    public function myOrders(Request $request, Response $response): Response
    {
        /** @var User $user */
        $user = $request->getAttribute('user');

        return $this->twig->render($response, 'orders/index.twig',
            [
                'orders' => $this->orderService->getAllByUser($user),
            ]);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $this->requestValidatorFactory->make(CreateOrderDataValidator::class)->validate(
            $request->getParsedBody()
        );
        $orderAddDto = OrderAddDto::fromArrayAndUser($data, $request->getAttribute('user'));
        $this->orderService->create($orderAddDto);

        return $response->withHeader('Location', '/orders')->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->orderService->delete((int)$args['id']);

        return $response->withHeader('Location', '/orders')->withStatus(302);
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        $order = $this->orderService->getById((int)$args['id']);

        if (!$order) {
            return $response->withStatus(404);
        }

        $data = ['id' => $order->getId(), 'name' => $order->getName()];

        return $this->responseFormatter->asJson($response, $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $this->requestValidatorFactory->make(UpdateOrderRequestValidator::class)->validate(
            $args + $request->getParsedBody()
        );

        $order = $this->orderService->getById((int)$data['id']);

        if (!$order) {
            return $response->withStatus(404);
        }

        $updatedOrder = $this->orderService->update($order, $data['name']);

        $this->responseFormatter->asJson($response, [
            'message' => "order updated successfully",
            'data' => OrderUpdateDto::fromEntity($updatedOrder),
        ]);
        return $response;
    }
}
