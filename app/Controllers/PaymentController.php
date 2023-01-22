<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Stripe\Checkout\Session;
use Stripe\StripeClient;

class PaymentController
{
    const SUCCES_HTML_BODY = '<!DOCTYPE html>
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
</html>';
    const CANCEL_HTML_BODY = '<!DOCTYPE html>
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
</html>';

    public function __construct(
        private readonly Twig         $twig,
        private readonly StripeClient $stripeClient
    )
    {
    }

    public function success(Request $request, Response $response, array $args): Response
    {
        $session_id = $args['session_id'];
        var_dump($session_id);
        $session = $this->stripeClient->checkout->sessions->retrieve($session_id);
        $customer = $this->stripeClient->customers->retrieve($session->customer);
        echo "Intent: " . $session->payment_intent . "<br>";
        echo "status: " . $session->payment_status . "<br>";
        echo "total: " . $session->amount_total . "<br>";
        echo "<h1>Thanks for your order," . $customer->name . "!</h1>";


        $response->getBody()->write(
            self::SUCCES_HTML_BODY
        );
        return $response;
    }

    public function cancel(Request $request, Response $response): Response
    {
        $response->getBody()->write(
            self::CANCEL_HTML_BODY
        );
        return $response;
    }

    public function checkout(Request $request, Response $response, array $args): Response
    {
        $orderId = $args['order_id'];

        /** @var User $user */
        $user = $request->getAttribute('user');


        // Set the Content-Type header to application/json
        $response = $response->withHeader('Content-Type', 'application/json');

        // Define your success and cancel URLs
        $YOUR_DOMAIN = 'http://localhost:8000/payments';
        $success_url = $YOUR_DOMAIN . '/success/' . '{CHECKOUT_SESSION_ID}';
        $cancel_url = $YOUR_DOMAIN . '/cancel';

        // Create the Checkout Session
        $currency = "pln";

        $checkout_session = Session::create([
            'line_items' => [
                $this->generateProduct($currency, "Product name", "desc", 500, 1),
                $this->generateProduct($currency, "Product name 2", "desc", 400, 2),
            ],
            'mode' => 'payment',
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
        ]);

        //todo save paymentid to database and track status with webhook
        // $paymentId = $checkout_session->payment_intent;
        // Redirect the user to the Checkout page
        return $response->withStatus(303)->withHeader('Location', $checkout_session->url);
    }

    public function test(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'payment/test.twig');
    }

    public function generateProduct(string $currency, string $productName, string $description, int $amount, int $quantity): array
    {
        return [
            'price_data' => [
                "currency" => $currency,
                "product_data" => [
                    "name" => $productName,
                    "description" => $description
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => $quantity,
        ];
    }


}
