<?php
declare(strict_types=1);

class FractionResults {
    public function __construct(
        public string $sum,
        public string $diff,
        public string $prod,
        public string $quot,
        public string $max
    ) {}
}

class Fraction {

    public function __construct(
            private int $numerator,
            private int $denominator
        ) {
            if ($this->denominator === 0) {
                throw new Exception("Denominator cannot be zero.");
            }
            $this -> simplify();
        }

    private function simplify(): void {
        $gcd = $this -> gcd($this -> numerator, $this -> denominator);
        $this -> numerator /= $gcd;
        $this -> denominator /= $gcd;

        if ($this -> denominator < 0) {
            $this -> numerator = -$this -> numerator;
            $this -> denominator = -$this -> denominator;
        }
    }

    private function gcd(int $a, int $b): int {
        if ($b == 0) {
            return abs($a);
        }
        return $this -> gcd($b, $a % $b);
    }

    public function add(Fraction $other): Fraction {
        $newN = $this -> numerator * $other -> denominator + $other -> numerator * $this -> denominator;
        $newD = $this -> denominator * $other -> denominator;
        return new Fraction($newN, $newD);
    }

    public function subtract(Fraction $other): Fraction {
        $newN = $this -> numerator * $other -> denominator - $other -> numerator * $this -> denominator;
        $newD = $this -> denominator * $other -> denominator;
        return new Fraction($newN, $newD);
    }

    public function multiply(Fraction $other): Fraction {
        $newN = $this -> numerator * $other -> numerator;
        $newD = $this -> denominator * $other -> denominator;
        return new Fraction($newN, $newD);
    }

    public function divide(Fraction $other): Fraction {
        if ($other -> numerator == 0) {
            throw new Exception ("divider cannot be zero.");
        }
        $newN = $this -> numerator * $other -> denominator;
        $newD = $this -> denominator * $other -> numerator;
        return new Fraction($newN, $newD);
    }

    public function compare(Fraction $other): int {
        $value1 = $this -> numerator / $this -> denominator;
        $value2 = $other -> numerator / $other -> denominator;

        if ($value1 > $value2) {
            return 1;
        } else if ($value1 < $value2) {
            return -1;
        } else {
            return 0;
        }
    }

    public function display(): string {
        return $this -> numerator . "/" . $this -> denominator;
    }
}

    $results = null;
    $emptyCheck = function($value) {
        return isset($value) && $value !== '';
    };

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numerator1   = (int)$_POST['numerator1'];
        $denominator1 = (int)$_POST['denominator1'];
        $numerator2   = (int)$_POST['numerator2'];
        $denominator2 = (int)$_POST['denominator2'];

        if ($emptyCheck($numerator1) && $emptyCheck($denominator1) && $emptyCheck($numerator2) && $emptyCheck($denominator2)) {
            try {
                $fraction1 = new Fraction($numerator1, $denominator1);
                $fraction2 = new Fraction($numerator2, $denominator2);

                $results = new FractionResults(
                    $fraction1 -> add($fraction2) -> display(),
                    $fraction1 -> subtract($fraction2) -> display(),
                    $fraction1 -> multiply($fraction2) -> display(),
                    $fraction1 -> divide($fraction2) -> display(),
                    ($fraction1 -> compare($fraction2) >= 0) ? $fraction1 -> display() : $fraction2 -> display()
                );
            } catch (Exception $e) {
                echo "Error: " . $e -> getMessage();
            }
        } else {
            echo "Please fill in all fields.";
        }
    }
    ?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fraction Operations</title>
</head>
<body>
    <header>
        <h1>Fraction Operations</h1>
    </header>

    <main>
        <section>
            <form method="post">
                <div>
                    <p>Enter the first fraction:</p>
                    <input type="number" name="numerator1" placeholder="Numerator" min="0" required>
                    <input type="number" name="denominator1" placeholder="Denominator" min="1" required>
                </div>

                <div>
                    <p>Enter the second fraction:</p>
                    <input type="number" name="numerator2" placeholder="Numerator" min="0" required>
                    <input type="number" name="denominator2" placeholder="Denominator" min="1" required>
                </div>

                <button type="submit">Calculate</button>
            </form>

            <div>
                <?php if(isset($results)): ?>
                    <h3>Results</h3>
                        <ul>
                            <li>Sum: <?php echo $results['sum']; ?></li>
                            <li>Difference: <?php echo $results['diff']; ?></li>
                            <li>Product: <?php echo $results['prod']; ?></li>
                            <li>Quotient: <?php echo $results['quot']; ?></li>
                            <li>Maximum: <?php echo $results['max']; ?></li>
                        </ul>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>

    </footer>

</body>
</html>