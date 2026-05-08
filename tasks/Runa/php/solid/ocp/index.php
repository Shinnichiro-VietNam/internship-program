<?php
require_once 'ocp_good.php';

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