<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_14</title>
</head>
<body>
    <h1>Calculate S(n) = x + x^3 + x^5 + … + x^2n + 1</h1>
    <ul>
        <li>Sum of odd powers.</li>
        <li>Use a for loop.</li>
    </ul>

    <form method="post">
        <input type="number" name="x" placeholder="Enter the base(x)" required>
        <input type="number" name="n" placeholder="Enter the exponent number(n)" min="0" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if ($_POST['n'] !== "") {
        $x = (int)$_POST['x'];
        $n = (int)$_POST['n'];
        $sum = 0;
        for ($i = 0; $i <= $n; $i++) {
            $sum += $x ** (2 * $i + 1);
        }
        echo "<h2>Total: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>