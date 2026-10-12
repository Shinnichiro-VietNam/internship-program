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

$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = (float)($_POST['amount'] ?? 0);
    $type = $_POST['type'] ?? '';

    // Select the class to use
    $payment = match ($type) {
        'credit' => new CreditCardPayment(),
        'paypal' => new PayPalPayment(),
        'bank'   => new BankTransferPayment(),
        default  => null
    };

    if ($payment) {
        $processor = new PaymentProcessor();
        ob_start();
        $processor->process($payment, $amount);
        $result = ob_get_clean();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><title>SOLID OCP Demo</title></head>
<body>
    <h2>Payment System (OCP)</h2>

    <form method="POST">
        Amount: <input type="number" name="amount" value="100"><br>
        Method:
        <select name="type">
            <option value="credit">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank">Bank Transfer</option>
        </select>
        <button type="submit">Pay Now</button>
    </form>

    <?php if ($result): ?>
        <p><strong>Result:</strong> <?php echo htmlspecialchars($result); ?></p>
    <?php endif; ?>

</body>
</html>