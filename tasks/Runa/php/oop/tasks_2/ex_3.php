<?php

declare(strict_types=1);

class Point {
    private float $x;
    private float $y;

    public function __construct(float $x, float $y) {
        $this->x = $x;
        $this->y = $y;
    }

    public function setX(float $x): void {
        $this->x = $x;
    }

    public function setY(float $y): void {
        $this->y = $y;
    }

    public function getX(): float {
        return $this->x;
    }

    public function getY(): float {
        return $this->y;
    }

    public function translate(float $dx, float $dy): void {
        $this->x += $dx;
        $this->y += $dy;
    }

    public function rotate(float $angle): void {
        $x = $this->x * cos(deg2rad($angle)) - $this->y * sin(deg2rad($angle));
        $y = $this->x * sin(deg2rad($angle)) + $this->y * cos(deg2rad($angle));
        $this->x = $x;
        $this->y = $y;
    }

    public function display(): string {
        $foundedX = round($this->x, 2);
        $foundedY = round($this->y, 2);
        return "({$foundedX}, {$foundedY})";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_3</title>
</head>
<body>
    <h1>Point Transformations</h1>
    <form method="post">
        <div>
            <h3>1. Initial Position（初期座標）</h3>
            <label>x:</label> <input type="number" step="any" name="x" value="0" required><br>
            <label>y:</label> <input type="number" step="any" name="y" value="0" required>
        </div>
        <div>
            <h3>2. Transformation Parameters（移動・回転の指定）</h3>
            <label>Move DX:</label> <input type="number" step="any" name="dx" value="0"><br>
            <label>Move DY:</label> <input type="number" step="any" name="dy" value="0"><br>
            <label>Angle (°):</label> <input type="number" step="any" name="angle" value="0">
        </div>

        <button type="submit">Execute Transformation</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $x = (float)$_POST['x'];
        $y = (float)$_POST['y'];
        $dx = (float)$_POST['dx'];
        $dy = (float)$_POST['dy'];
        $angle = (float)$_POST['angle'];
        $point = new Point($x, $y);
        $point->translate($dx, $dy);
        $point->rotate($angle);
        echo "<h3>Result:</h3>";
        echo $point->display();
    }
    ?>
</body>
</html>