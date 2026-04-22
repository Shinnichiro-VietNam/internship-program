<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_8</title>
</head>
<body>
    <h1>Calculate S(n) = ½ + ¾ + 5/6 + … + 2n + 1/ 2n + 2</h1>
    <ul>
        <li>Sum of (2k+1)/(2k+2) for k=0 to n-1.</li>
        <li>Use a for loop.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="0" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if (isset($_POST['n']) && $_POST['n'] !== "") {
        $n = (int)$_POST['n'];
        $sum = 0.0;

        for ($k = 0; $k <= $n - 1; $k++) {
            $sum += (2 * $k + 1) / (2 * $k + 2);
        }
        echo "<h2>Sum: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>