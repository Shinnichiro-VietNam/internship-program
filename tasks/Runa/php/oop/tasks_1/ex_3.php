<?php
declare(strict_types=1);
class Student {
    private string $fullName;
    private float $mathScore;
    private float $literatureScore;

    public function __construct(string $fullName, float $mathScore, float $literatureScore) {
        $this->fullName = $fullName;
        $this->setMathScore($mathScore);
        $this->setLiteratureScore($literatureScore);
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    public function setMathScore(float $score) {
        if ($score < 0) {
            throw new Exception("Math score must be a positive number greater than or equal to 0.");
        }
        $this->mathScore = $score;
    }

    public function getMathScore(): float {
        return $this->mathScore;
    }

    public function setLiteratureScore(float $score) {
        if ($score < 0) {
            throw new Exception("Literature score must be a positive number greater than or equal to 0.");
        }
        $this->literatureScore = $score;
    }

    public function getLiteratureScore(): float {
        return $this->literatureScore;
    }

    public function calculateAverage(): float {
        return ($this->mathScore + $this->literatureScore) / 2;
    }

    public function displayInfo(): array {
        $average = $this->calculateAverage();
        return [
            'name' => $this->getFullName(),
            'average' => $average
        ];
    }
}
?>

<?php
$results = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $math = (float) $_POST['math'];
    $literature = (float) $_POST['literature'];

    $student = new Student($name, $math, $literature);
    $results = $student->displayInfo();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Average Score</title>
</head>
<body>
    <header>
        <h1>Student Average Score</h1>
    </header>

    <main>
        <div>
            <form method="post">
                <label>Student full name:</label>
                <input type="text" name="name" placeholder="Yamada Taro" required>

                <label>Math score:</label>
                <input type="number" name="math" step="any" required>

                <label>Literature score:</label>
                <input type="number" name="literature" step="any" required>

                <button type="submit">Calculate Average Score</button>
            </form>
        </div>
        <div>
            <?php if(isset($results)): ?>
                <h3>Average Score</h3>
                <p>Name: <?php echo $results['name']; ?></p>
                <p>Average: <?php echo $results['average']; ?></p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
    </footer>

</body>
</html>