<?php
declare(strict_types=1);
class ComplexNumber {
    private float $real;
    private float $imaginary;

    public function __construct(float $real, float $imaginary) {
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    public function add(ComplexNumber $other): ComplexNumber {
        $realPart = $this->real + $other->real;
        $imaginaryPart = $this->imaginary + $other->imaginary;
        return new ComplexNumber($realPart, $imaginaryPart);
    }

    public function subtract(ComplexNumber $other): ComplexNumber {
        $realPart = $this->real - $other->real;
        $imaginaryPart = $this->imaginary - $other->imaginary;
        return new ComplexNumber($realPart, $imaginaryPart);
    }

    public function multiply(ComplexNumber $other): ComplexNumber {
        $realPart = ($this->real * $other->real) - ($this->imaginary * $other->imaginary);
        $imaginaryPart = ($this->real * $other->imaginary) + ($this->imaginary * $other->real);
        return new ComplexNumber($realPart, $imaginaryPart);
    }

    public function divide(ComplexNumber $other): ComplexNumber {
        $denominator = ($other->real ** 2) + ($other->imaginary ** 2);

        if ($denominator == 0) {
            throw new Exception("Division by zero is not allowed.");
        }

        $realPart = (($this->real * $other->real) + ($this->imaginary * $other->imaginary)) / $denominator;
        $imaginaryPart = (($this->imaginary * $other->real) - ($this->real * $other->imaginary)) / $denominator;
        return new ComplexNumber($realPart, $imaginaryPart);
    }

    public function display(): string {
        $sign = $this->imaginary >= 0 ? '+' : '-';
        $imaginaryValue = abs($this->imaginary);
        return "{$this->real} {$sign} {$imaginaryValue}i";
    }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complex Numbers</title>
</head>
<body>
    <header>
        <h1>Complex Numbers</h1>
    </header>
    <main>
        <form method="post">
            <h3>Number 1</h3>
            Real: <input type="number" step="any" name="real1" required>
            Imaginary: <input type="number" step="any" name="imaginary1" required>

            <h3>Number 2</h3>
            Real: <input type="number" step="any" name="real2" required>
            Imaginary: <input type="number" step="any" name="imaginary2" required>

            <button type="submit">Calculate</button>
        </form>
    </main>
    <footer>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $real1 = (float)$_POST['real1'];
            $imaginary1 = (float)$_POST['imaginary1'];
            $real2 = (float)$_POST['real2'];
            $imaginary2 = (float)$_POST['imaginary2'];

            $number1 = new ComplexNumber($real1, $imaginary1);
            $number2 = new ComplexNumber($real2, $imaginary2);

            echo "<h3>Results:</h3>";
            echo "Number 1: " . $number1->display() . "<br>";
            echo "Number 2: " . $number2->display() . "<br><br>";

            echo "Addition: " . $number1->add($number2)->display() . "<br>";
            echo "Subtraction: " . $number1->subtract($number2)->display() . "<br>";
            echo "Multiplication: " . $number1->multiply($number2)->display() . "<br>";
            echo "Division: " . $number1->divide($number2)->display() . "<br>";
        }
        ?>
    </footer>
</body>
</html>
