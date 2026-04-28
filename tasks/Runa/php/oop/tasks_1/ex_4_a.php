<?php
declare(strict_types=1);
class IntegerArray {
    private array $elements;

    public function __construct(string $input) {
        $raw = explode(',', $input);
        $filtered = array_filter(array_map('trim', $raw), 'strlen');
        $this->elements = array_map('intval', $filtered); // If a user mistakenly enters consecutive commas like 5,,8, `intval` will convert the empty string to 0, so this is to prevent that.
    }

    public function sortAscending(): void {
        sort($this->elements);
    }

    public function displayArray(): string  {
        return implode(', ', $this->elements);
    }
}
$results = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputArray = $_POST['input_array'];
    $integerArray = new IntegerArray($inputArray);
    $integerArray->sortAscending();
    $results = $integerArray->displayArray();
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Sorting</title>
</head>
<body>
    <header>
        <h1>Array Sorting</h1>
    </header>

    <main>
        <form method="post">
            <p>Enter numbers separated by commas:</p>
            <input type="text" name="input_array" placeholder="e.g. 5,3,8,1" required>
            <button type="submit">Sort Array</button>
        </form>
        <div>
            <?php if(isset($results)): ?>
                <h3>Sorted Array</h3>
                <p><?php echo $results; ?></p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>