<?php
declare(strict_types=1);

class NumberProcessor {
    private int $number;

    public function __construct(int $n) {
        if ($n < 0) {
            throw new Exception("正の整数を入力してください。");
        }
        $this->number = $n;
    }

    public function getAnalytics(): array {
        $digits = str_split((string) $this->number);
        $numDigits = array_map('intval', $digits);

        $sum = array_sum($numDigits);
        $count = count($numDigits);
        $product = array_product($numDigits);
        $max = max($numDigits);
        $min = min($numDigits);

        $frequency = array_count_values($numDigits);

        return [
            'Sum' => $sum,
            'Count' => $count,
            'Product' => $product,
            'First Digit' => $digits[0],
            'Reversed' => strrev((string)$this->number),
            'Max Digit' => "$max (出現数: {$frequency[$max]})",
            'Frequency of Max Digit' => $frequency[$max],
            'Min Digit' => "$min (出現数: {$frequency[$min]})",
            'Frequency of Min Digit' => $frequency[$min],
        ];
    }

    public function isSymmetric(): bool {
        $str = (string) $this->number;
        return $str === strrev($str);
    }

    public function isOrdered(): int {
        $digits = str_split((string)$this->number);
        if (count($digits) < 2) return 0;

        $increasing = true;
        $decreasing = true;

        for ($i = 0; $i < count($digits) - 1; $i++) {
            if ($digits[$i] >= $digits[$i+1]) $increasing = false;
            if ($digits[$i] <= $digits[$i+1]) $decreasing = false;
        }

        if ($increasing) return 1;
        if ($decreasing) return -1;
        return 0;
    }
}

$results = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['number'])) {
    try {
        $n = (int)$_POST['number'];
        $processor = new NumberProcessor($n);

        $results = [
            'analytics' => $processor->getAnalytics(),
            'symmetric' => $processor->isSymmetric() ? "Yes (回文)" : "No",
            'order' => match($processor->isOrdered()) {
                1 => "Strictly Increasing (厳密に増加)",
                -1 => "Strictly Decreasing (厳密に減少)",
                0 => "No Specific Order (特定の順序無し)"
            }
        ];
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Integer Analytics</title>
</head>
<body>
    <h1>Advanced Integer Analytics</h1>

    <form method="post">
        <input type="number" name="number" value="<?= htmlspecialchars($_POST['number'] ?? '') ?>" required min="0">
        <button type="submit">Analyze Number</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($results)): ?>
        <h3>Results</h3>
        <ul>
            <li>Sum: <?php echo $results['analytics']['Sum']; ?></li>
            <li>Count: <?php echo $results['analytics']['Count']; ?></li>
            <li>Product: <?php echo $results['analytics']['Product']; ?></li>
            <li>First Digit: <?php echo $results['analytics']['First Digit']; ?></li>
            <li>Reversed: <?php echo $results['analytics']['Reversed']; ?></li>
            <li>Maximum: <?php echo $results['analytics']['Max Digit']; ?></li>
            <li>Minimum: <?php echo $results['analytics']['Min Digit']; ?></li>
            <li>Symmetric: <?php echo $results['symmetric']; ?></li>
            <li>Digit Order: <?php echo $results['order']; ?></li>
        </ul>
    <?php endif; ?>
</body>
</html>