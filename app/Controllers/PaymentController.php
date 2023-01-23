<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use App\Exceptions\OrderIsPaidException;
use App\Services\OrderService;
use App\Services\PaymentService;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Stripe\StripeClient;

class PaymentController
{
    public function __construct(
        private readonly Twig           $twig,
        private readonly StripeClient   $stripeClient,
        private readonly OrderService   $orderService,
        private readonly PaymentService $paymentService,
    )
    {
    }

    public function success(Request $request, Response $response, array $args): Response
    {
        $session_id = $args['session_id'];

        $session = $this->stripeClient->checkout->sessions->retrieve($session_id);
        if (!$session) {
            throw new InvalidArgumentException();
        }

        $order = $this->orderService->getByPaymentId($session_id);
        $this->orderService->updatePaymentSession($order, $session_id, $session->payment_status);

        return $this->twig->render(
            $response,
            'redirect.twig',
            [
                'url' => '/orders/my',
                'message' => '<div><p style="color: green">Your payment has been accepted.</p><p>Thank you for ordering in our 3D printing service.</p><p>You will now be redirected to <a href="{{ url }}" class="text-primary">order page</a> in few seconds.</p></div>',
                'delay' => 5000
            ]
        );
    }

    public function cancel(Request $request, Response $response): Response
    {
        return $this->twig->render(
            $response,
            'redirect.twig',
            [
                'url' => '/orders/my',
                'message' => '<div><p style="color: red">Your payment has been canceled.</p><p>You will now be redirected to <a href="{{ url }}" class="text-primary">order page</a> in few seconds.</p></div>',
                'delay' => 5000
            ]
        );
    }

    public function checkout(Request $request, Response $response, array $args): Response
    {
        $orderId = $args['order_id'];

        /** @var User $user */
        $user = $request->getAttribute('user');
        $order = $this->orderService->getById(intval($orderId));

        if ($order->getUser()->getId() != $user->getId()) {
            throw new InvalidArgumentException("You can checkout only your orders");
        }
        if ($order->isPaid()) {
            throw new OrderIsPaidException("Order is already paid");
        }

        // Set the Content-Type header to application/json
        $response = $response->withHeader('Content-Type', 'application/json');

        $checkout_session = $this->paymentService->generatePaymentSession($order);

        return $response->withStatus(303)->withHeader('Location', $checkout_session->url);
    }


}
