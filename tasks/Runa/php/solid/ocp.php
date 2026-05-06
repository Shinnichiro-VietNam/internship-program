<?php

class PaymentProcessor
{
    public function process(string $method, float $amount): void
    {
        if ($method === "credit_card") {
            echo "Processing credit card payment of $" . $amount . PHP_EOL;
        } elseif ($method === "paypal") {
            echo "Processing PayPal payment of $" . $amount . PHP_EOL;
        } elseif ($method === "bank_transfer") {
            echo "Processing bank transfer payment of $" . $amount . PHP_EOL;
        } else {
            echo "Unsupported payment method." . PHP_EOL;
        }
    }
}

$processor = new PaymentProcessor();
$processor->process("credit_card", 120.50);
$processor->process("paypal", 75.00);
