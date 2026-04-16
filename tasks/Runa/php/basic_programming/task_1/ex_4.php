<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_4</title>
</head>
<body>
    <h1>Calculate S(n) = ½ + ¼ + … + 1/2n</h1>
    <ul>
        <li>Sum of 1/(2k) for k=1 to n.</li>
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

        for ($i = 1; $i <= $n; $i++) {
            $sum += 1.0 / ($i * 2);
        }
        echo "<h2>Sum: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>