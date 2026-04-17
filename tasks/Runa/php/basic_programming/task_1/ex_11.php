<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_11</title>
</head>
<body>
    <h1>Calculate S(n) = 1 + 1.2 + 1.2.3 + … + 1.2.3….N </h1>
    <ul>
        <li>Sum of factorials up to n.</li>
        <li>Use nested loops or factorial function.</li>
        <li>Draw a flowchart for the control structure using draw.io.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="0" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    //empty("0") は true (空である) と判定され、計算がスキップされてしまうのを防ぐためです。
    //The reason for not using empty() is that when the user enters "0"
    //This is to prevent the calculation from being skipped, as empty("0") would be judged as true (empty).
    if (isset($_POST['n']) && $_POST['n'] !== "")
    {
        $n = (int)$_POST['n'];
        $sum = 0;
        $factorial = 1;

        for ($i = 1; $i <= $n; $i++) {
            $factorial *= $i;
            $sum += $factorial;
        }
        echo "<h2>Total: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>