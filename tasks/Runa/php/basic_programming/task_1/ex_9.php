<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_9</title>
</head>
<body>
    <h1>Calculate T(n) = 1 x 2 x 3…x N</h1>
    <ul>
        <li>Calculate the factorial of n.</li>
        <li>Use a for loop.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" placeholder="Enter a positive number" min="0" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if ($_POST['n'] !== "") {
        $n = (int)$_POST['n'];
        $T = 1;

        for ($i = 1; $i <= $n; $i++) {
            $T *= $i;
        }
        echo "<h2>Total: $T</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>