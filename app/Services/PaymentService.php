<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Stripe\Checkout\Session;
use Stripe\StripeClient;

define('YOUR_DOMAIN', 'http://localhost:8000/payments');

class PaymentService
{
    private string $currency = "pln";
    private $success_url = YOUR_DOMAIN . '/success/' . '{CHECKOUT_SESSION_ID}';
    private $cancel_url = YOUR_DOMAIN . '/cancel';

    public function __construct(private readonly EntityManager $entityManager,
                                private readonly OrderService  $orderService,
                                private readonly StripeClient  $stripeClient
    )
    {
    }

    public function generatePaymentSession(Order $order): Session
    {
        $checkout_session = Session::create([
            'line_items' => $this->getLineItems($order->getItems()),
            'mode' => 'payment',
            'success_url' => $this->success_url,
            'cancel_url' => $this->cancel_url,
        ]);
        $this->orderService->updatePaymentSession($order, $checkout_session->id, $checkout_session->payment_status);
        return $checkout_session;
    }

    public function getLineItems(Collection $products): array
    {
        $lineItems = array();

        foreach ($products as $product) {
            $lineItems[] = $this->generateStripeProduct($product);
        }

        return $lineItems;
    }

    private function generateStripeProduct(OrderItem $orderItem): array
    {
        $stripeAmount = round($orderItem->getUnitPrice() * 100, 2);
        return [
            'price_data' => [
                "currency" => $this->currency,
                "product_data" => [
                    "name" => $orderItem->getPrintingModel()->getOriginalName(),
                    "description" => $orderItem->getPrintingModel()->getOriginalName()
                ],
                'unit_amount' => $stripeAmount,
            ],
            'quantity' => $orderItem->getQuantity(),
        ];
    }

}
