<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_2</title>
</head>
<body>
    <h1>Calculate S(n) = 1 + 1/3 + 1/5 + … + 1/(2n + 1)</h1>
    <ul>
        <li>Sum of odd denominators.</li>
        <li>Use a for loop.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="1" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if (!empty($_POST['n'])) {
        $n = (int)$_POST['n'];
        $sum = 0.0;

        for ($i = 0; $i <= $n; $i++) {
            $sum += 1.0 / ($i * 2 + 1);
        }
        echo "<h2>Sum: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>