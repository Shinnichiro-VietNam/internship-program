<?php

/**
 * * 【良い点（Good）】
 * 1. OCPに基づいて、既存のクラスを修正せずに新しい支払い方法を追加できる
 * You can add new payment methods without modifying existing classes.
 * 2. 各支払い方法のロジックが独立しているため、メンテナンスが簡単
 * Each payment logic is independent, making it easier to maintain.
 * 3. インターフェースを使用することで、PaymentProcessorが特定のクラスに依存しない
 * By using an interface, PaymentProcessor does not depend on concrete classes.
 */

interface PaymentMethod {
    public function process(float $amount): void;
}

class CreditCardPayment implements PaymentMethod {
    public function process(float $amount): void {
        echo "Processing credit card payment of $" . $amount . PHP_EOL;
    }
}

class PayPalPayment implements PaymentMethod {
    public function process(float $amount): void {
        echo "Processing PayPal payment of $" . $amount . PHP_EOL;
    }
}

class BankTransferPayment implements PaymentMethod {
    public function process(float $amount): void {
        echo "Processing bank transfer payment of $" . $amount . PHP_EOL;
    }
}

class PaymentProcessor {
    public function process(PaymentMethod $paymentMethod, float $amount): void {
        $paymentMethod->process($amount);
    }
}

// Uncomment to test
// $processor = new PaymentProcessor();
// $processor->process(new CreditCardPayment(), 100.00);
// $processor->process(new PayPalPayment(), 50.00);
// $processor->process(new BankTransferPayment(), 200.00);