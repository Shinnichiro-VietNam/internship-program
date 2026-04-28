<?php
declare(strict_types=1);

/**
 * 2次元座標上の点を表し、点同士の距離計算を担当する
 */
class Point {
    private float $x;
    private float $y;

    public function __construct(float $x, float $y) {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): float {
        return $this->x;
    }

    public function getY(): float {
        return $this->y;
    }

/**
 * 別の点との直線距離を計算する
*/

    public function calculateDistance(Point $other): float {
        $x1 = $this->x;
        $y1 = $this->y;
        $x2 = $other->getX();
        $y2 = $other->getY();

        return sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));

    }

}

class PointCollection {
    private array $points = [];

    public function addPoint(Point $p) {
        $this->points[] = $p;
    }

    public function findMaxDistancePoints(): array {
        $maxDistance = -1;
        $pair = [null, null];
        $n = count($this->points);

        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $distance = $this->points[$i]->calculateDistance($this->points[$j]);

                if ($distance > $maxDistance) {
                    $maxDistance = $distance;
                    $pair = [$this->points[$i], $this->points[$j]];
                }
            }
        }
        return $pair;
    }
}

$results = null;
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['points'])) {
    $input = $_POST['points'];
    $pointStrings = explode(' ', $input);
    $collection = new PointCollection();

    foreach ($pointStrings as $pointString) {
        $coords = explode(',', $pointString);
        if (count($coords) == 2) {
            $collection->addPoint(new Point((float)$coords[0], (float)$coords[1]));
        }
    }

    $maxDistancePoints = $collection->findMaxDistancePoints();

    if (isset($maxDistancePoints[0]) && isset($maxDistancePoints[1])) {
        $distance = $maxDistancePoints[0]->calculateDistance($maxDistancePoints[1]);
        $results = "Point 1: (" . $maxDistancePoints[0]->getX() . ", " . $maxDistancePoints[0]->getY() . ") and" .
                "Point 2: (" . $maxDistancePoints[1]->getX() . ", " . $maxDistancePoints[1]->getY() . ")<br>" .
                "Distance: " . round($distance, 2);
    } else {
        $error = "Please enter at least two valid points.";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Point Geometry</title>
    </head>
    <body>
        <header>
            <h1>Point Geometry</h1>
        </header>
        <main>
            <form method="post">
                <h2>4b: Find Max Distance Points</h2>
                <p>Please enter the coordinates in the format "x,y" separated by spaces:</p>
                <input type="text" name="points" placeholder="e.g. 1,2 3,4 5,6" required>
                <button type="submit">Calculate</button>
            </form>
            <div>
                <?php if(!empty($error)): ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if(isset($results)): ?>
                    <h3>Maximum Distance Points</h3>
                    <p><?php echo $results; ?></p>
                <?php endif; ?>
            </div>
        </main>
        <footer>
        </footer>
    </body>
</html>