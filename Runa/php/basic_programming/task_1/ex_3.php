<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_3</title>
</head>
<body>
    <h1>Calculate S(n) = 1 + ½ + 1/3 + … + 1/n </h1>
    <ul>
        <li>Calculate the harmonic series sum up to n.</li>
        <li>Use a for loop with floating point division.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="1" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if (isset($_POST['n']) && $_POST['n'] !== "") {
        $n = (int)$_POST['n'];
        $sum = 0.0;

        for ($i = 1; $i <= $n; $i++) {
            $sum += 1 / $i;
        }
        echo "<h2>Sum: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>