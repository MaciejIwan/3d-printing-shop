<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\RequestValidatorFactoryInterface;
use App\ResponseFormatter;
use App\Services\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Stripe\Stripe;

class PaymentController
{
    public function __construct(
        private readonly Twig                             $twig,
        private readonly RequestValidatorFactoryInterface $requestValidatorFactory,
        private readonly OrderService                     $orderService,
        private readonly ResponseFormatter                $responseFormatter
    )
    {
    }

    public function success(Request $request, Response $response): Response
    {
        $response->getBody()->write(
            '<!DOCTYPE html>
<html>
<head>
  <title>Thanks for your order!</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <section>
    <p>
      We appreciate your business! If you have any questions, please email
      <a href="mailto:orders@example.com">orders@example.com</a>.
    </p>
  </section>
</body>
</html>'
        );
        return $response;
    }

    public function cancel(Request $request, Response $response): Response
    {
        $response->getBody()->write(
            '<!DOCTYPE html>
<html>
<head>
  <title>Checkout canceled</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <section>
    <p>Forgot to add something to your cart? Shop around then come back to pay!</p>
  </section>
</body>
</html>'
        );
        return $response;
    }

    public function checkout(Request $request, Response $response): Response
    {

        // Set the Content-Type header to application/json
        $response = $response->withHeader('Content-Type', 'application/json');

        // Define your success and cancel URLs
        $YOUR_DOMAIN = 'http://localhost:8000/payments';
        $success_url = $YOUR_DOMAIN . '/success';
        $cancel_url = $YOUR_DOMAIN . '/cancel';

        // Create the Checkout Session
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price' => 'price_1MS9LqKfUwlni2dZhaO3OgA9',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
        ]);

        // Redirect the user to the Checkout page
        return $response->withStatus(303)->withHeader('Location', $checkout_session->url);
    }

    public function test(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'payment/test.twig');
    }


}
