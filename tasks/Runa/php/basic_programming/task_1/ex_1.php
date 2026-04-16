<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>task_1_ex_1</title>
</head>
<body>
    <h1>Exercise 1: Calculate S(n) = 1 + 2 + 3 + … + n</h1>
    <ul>
        <li>Write a PHP script to calculate the sum of the first n natural numbers.</li>
        <li>Use a for loop.</li>
        <li>Input n from user.</li>
    </ul>

    <form method="post">
        <input type="number" name="n" min="1" placeholder="Enter Number" required>
        <button type="submit"> Calculate</button>
    </form>

    <?php
    if (!empty($_POST['n'])) {
        $n = $_POST['n'];
        $sum = 0;

        for ($i = 1; $i <= $n; $i++) {
            $sum += $i;
        }
        echo "<h2>Sum: $sum</h2>";
    } else {
        echo "Enter a number";
    }
    ?>
</body>
</html>