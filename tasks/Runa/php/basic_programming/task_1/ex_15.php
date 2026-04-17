<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_15</title>
</head>
<body>
    <h1>Calculate S(n) = 1 + 1/1 + 2 + 1/ 1 + 2 + 3 + ….. + 1/ 1 + 2 + 3 + …. + N</h1>
    <ul>
        <li>Complex sum involving cumulative sums.</li>
        <li>Use nested loops.</li>
        <li>Draw a flowchart for the control structure using draw.io.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="0" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if ($_POST['n'] !== "") {
        $n = (int)$_POST['n'];
        $sum = 0;
        for ($i = 1; $i <= $n; $i++) {
            $d = 0;
            for ($j = 1; $j <= $i; $j++) {
                $d += $j;
            }
            $sum += 1 / $d;
        }
        echo "<h2>Total: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>