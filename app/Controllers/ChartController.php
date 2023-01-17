<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Dto\OrderUpdateDto;
use App\RequestValidators\AddShoppingChartItemRequestValidator;
use App\RequestValidators\UpdateOrderRequestValidator;
use App\ResponseFormatter;
use App\Services\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class ChartController
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
        $user = $request->getAttribute('user');

        return $this->twig->render(
            $response,
            'orders/index.twig',
            [
                'orders' => $user->getShoppingCardItems(),
            ]
        );
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $this->requestValidatorFactory->make(AddShoppingChartItemRequestValidator::class)->validate(
            $request->getParsedBody()
        );

        $this->orderService->create($data['name'], $request->getAttribute('user'));

        return $response->withHeader('Location', '/orders')->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $this->orderService->delete((int)$args['id']);

        return $response->withHeader('Location', '/orders')->withStatus(302);
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        $category = $this->orderService->getById((int)$args['id']);

        if (!$category) {
            return $response->withStatus(404);
        }

        $data = ['id' => $category->getId(), 'name' => $category->getName()];

        return $this->responseFormatter->asJson($response, $data);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $this->requestValidatorFactory->make(UpdateOrderRequestValidator::class)->validate(
            $args + $request->getParsedBody()
        );

        $category = $this->orderService->getById((int)$data['id']);

        if (!$category) {
            return $response->withStatus(404);
        }

        $updatedCategory = $this->orderService->update($category, $data['name']);

        $this->responseFormatter->asJson($response, [
            'message' => "order updated successfully",
            'data' => OrderUpdateDto::fromEntity($updatedCategory),
        ]);
        return $response;
    }
}
