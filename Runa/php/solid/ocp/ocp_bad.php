<?php

/**
 * * 【悪い点（Bad）】
 * 1. 新しい支払い方法を追加する場合、PaymentProcessorクラスを修正する必要がある
 * If you want to add a new payment method, you need to modify the PaymentProcessor class
 * 2. 支払い方法ごとに異なる処理を行う場合、PaymentProcessorクラスを修正する必要がある
 * If you want to perform different processing for each payment method, you need to modify the PaymentProcessor class
 */

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
