<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_12</title>
</head>
<body>
    <h1>Calculate S(n) = x + x^2 + x^3 + … + x^n</h1>
    <ul>
        <li>Geometric series sum.</li>
        <li>Use a for loop.</li>
    </ul>

    <form method="post">
        <input type="number" name="x" placeholder="Enter the base(x)" required>
        <input type="number" name="n" placeholder="Enter the exponent number(n)" min="0" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if (isset($_POST['x']) && $_POST['x'] !== "" && isset($_POST['n']) && $_POST['n'] !== "") {
        $x = (int)$_POST['x'];
        $n = (int)$_POST['n'];
        $sum = 0;
        for ($i = 1; $i <= $n; $i++) {
            $sum += $x ** $i;
        }
        echo "<h2>Total: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>