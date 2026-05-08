<?php
declare(strict_types=1);

class MathUtil {
    public static function gcd(int $a, int $b): int {
        $a = abs($a);
        $b = abs($b);
        while ($b > 0) {
            $temp = $b;
            $b = $a % $b;
            $a = $temp;
        }
        return $a;
    }

    public static function lcm(int $a, int $b): int {
        return (int)(abs($a * $b) / self::gcd($a, $b));
    }

    public static function isAllOdd(int $n): bool {
        $n = abs($n);
        if ($n === 0) return false;
        while ($n > 0) {
            if (($n % 10) % 2 === 0) {
                return false;
            }
            $n = (int)($n / 10);
        }
        return true;
    }
}
?>

<?php
$results = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a = (int)$_POST['a'];
    $b = (int)$_POST['b'];
    $results = [
        'gcd' => MathUtil::gcd($a, $b),
        'lcm' => MathUtil::lcm($a, $b),
        'isAllOdd' => MathUtil::isAllOdd($a)
    ];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Utility</title>
</head>
<body>
    <header>
        <h1>Math Utility</h1>
    </header>

    <main>
    <form method="post">
        <input type="number" name="a" placeholder="Enter a" required>
        <input type="number" name="b" placeholder="Enter b" required>
        <button type="submit">Calculate</button>
    </form>

    <?php if (isset($results)): ?>
        <h2>Results</h2>
        <p>GCD: <?php echo MathUtil::gcd((int)$_POST['a'], (int)$_POST['b']); ?></p>
        <p>LCM: <?php echo MathUtil::lcm((int)$_POST['a'], (int)$_POST['b']); ?></p>
        <p>Is All Odd: <?php echo MathUtil::isAllOdd((int)$_POST['a']) ? 'Yes' : 'No'; ?></p>
    <?php endif; ?>
    </main>

    <footer>
    </footer>
</body>
</html>