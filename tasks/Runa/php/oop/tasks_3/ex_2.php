<?php
declare(strict_types=1);

class SeriesSolver {
    public function findMaxK(int $n): array {
        $k = 0;
        $sum = 0;
        // 次のkを足してもnを超えないか判定
        while (($sum + ($k + 1)) < $n) {
            $k++;
            $sum += $k;
        }
        return ['k' => $k, 'sum' => $sum];
    }

    public function findMaxBonus(int $n): array {
        // 二次方程式の解の公式を利用
        $k_float = (-1 + sqrt(1 + 8 * $n)) / 2;
        $k = (int)floor($k_float);
        $sum = ($k * ($k + 1)) / 2;

        // 不等式 S(k) < n を満たすための調整
        if ($sum >= $n && $k > 0) {
            $k--;
            $sum = ($k * ($k + 1)) / 2;
        }
        return ['k' => $k, 'sum' => $sum];
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Largest K Series Solver</title>
</head>
<body>
    <h1>The Largest K Series Solver</h1>
    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="1" required>
        <button type="submit">Calculate</button>
    </form>

    <?php if (isset($_POST['n']) && $_POST['n'] !== ""):
        $n = (int)$_POST['n'];
        $solver = new SeriesSolver();
        $maxK = $solver->findMaxK($n);
        $maxBonus = $solver->findMaxBonus($n);
    ?>
    <div class="results">
        <h2>Results for n = <?php echo $n; ?></h2>
        <p>Loop Method:Max K = <?php echo $maxK['k']; ?>, Sum = <?php echo $maxK['sum']; ?></p>
        <p>Bonus Method:Max K = <?php echo $maxBonus['k']; ?>, Sum = <?php echo $maxBonus['sum']; ?></p>
    </div>
    <?php endif; ?>
</body>
</html>