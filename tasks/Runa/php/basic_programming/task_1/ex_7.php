<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_7</title>
</head>
<body>
    <h1>Calculate S(n) = ½ + 2/3 + ¾ + …. + n / n + 1 </h1>
    <ul>
        <li>Sum of k/(k+1) for k=1 to n.</li>
        <li>Use a for loop.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="1" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if ($_POST['n'] !== "") {
        $n = (int)$_POST['n'];
        $sum = 0.0;

        for ($k = 1; $k <= $n; $k++) {
            $sum += $k / ($k + 1);
        }
        echo "<h2>Sum: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>